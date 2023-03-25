const noticeBox = document.getElementById("starter");
const testForm = document.getElementById("test");
const test = {
	id: null,
	time: null,
	marks: null,
	questions: null,
	wrong: Array(),
	unattended: Array(),
	obtained: 0,
	percentage: null,
};
const testPerformance = {
	last: 0,
	current: 0,
	delta: 0,
	improved: null,
};

let questionCount = 1;
let stopTimer = false;
let submitted = false;

function createTest() {
	const xhttp = new XMLHttpRequest();
	xhttp.onload = function () {
		if (this.responseText.slice(1, 5).toLowerCase() != "error") {
			const resp = JSON.parse(this.responseText);
			test.id = resp.id;
			test.time = resp.time;
			test.questions = resp.questions;

			document.getElementById("total").innerText = test.marks;
			document.getElementById("left").innerText = test.marks;

			displayQuestions();
			startTimer();
			document.addEventListener("visibilitychange", () => {
				submitExam();
			});
		} else console.log(this.responseText);
	};
	xhttp.open("POST", "./scripts/api/tests.api.php");
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(`type=create&marks=${test.marks}`);
}

function displayQuestions() {
	test.questions.forEach((questionObj) => {
		const qID = questionObj.id;
		const question = decodeURIComponent(
			encodeURIComponent(
				questionObj.question
					.replace(/######/g, "</pre></code>")
					.replace(/#####/g, "<pre><code class='language-c'>")
			).replace(/%0A/g, "<br>")
		);
		const options = [
			{ id: "a", value: questionObj.option_a },
			{ id: "b", value: questionObj.option_b },
			{ id: "c", value: questionObj.option_c },
			{ id: "d", value: questionObj.option_d },
		].sort(randomSort);

		displayQuestion(qID, question, options);
		questionCount++;
	});

	let scriptTag = document.createElement("script");
	scriptTag.src = `./assets/prism/prism.js`;
	let head = document.getElementsByTagName("head")[0];
	head.appendChild(scriptTag);
}

function displayQuestion(id, ques, opts) {
	const questionBox = document.createElement("div");
	questionBox.className = "question-box";
	questionBox.id = `question-${id}`;

	const question = document.createElement("div");
	question.className = "question";
	question.innerHTML = `<span class="question-number">${questionCount}</span> ${ques}`;
	questionBox.appendChild(question);

	const optionBox = document.createElement("div");
	optionBox.className = "option-box";

	opts.forEach((optionObj) => {
		const optionContainer = document.createElement("div");
		optionContainer.className = "option";

		const optionRadioInput = document.createElement("input");
		optionRadioInput.type = `radio`;
		optionRadioInput.className = "option-radio";
		optionRadioInput.id = `option-${id}-${optionObj.id}`;
		optionRadioInput.name = `option-${id}`;
		optionRadioInput.value = optionObj.value;
		optionContainer.appendChild(optionRadioInput);

		const optionRadioLabel = document.createElement("label");
		optionRadioLabel.htmlFor = optionRadioInput.id;
		optionRadioLabel.textContent = he.decode(optionObj.value);
		optionContainer.appendChild(optionRadioLabel);
		optionRadioLabel.addEventListener("click", (e) => {
			selectOption(e);
		});

		optionBox.appendChild(optionContainer);
	});
	questionBox.appendChild(optionBox);

	testForm.appendChild(questionBox);
}

function selectOption(e) {
	const optionId = e.srcElement.htmlFor;
	const option = document.getElementById(optionId).parentElement;
	const optionList = option.parentElement.children;

	let reselect = false;
	if (!option.classList.contains("selected-option")) {
		for (let i = 0; i < optionList.length; i++) {
			if (optionList[i].classList.contains("selected-option")) {
				optionList[i].classList.remove("selected-option");
				reselect = true;
			}
		}
		option.classList.toggle("selected-option");
	} else reselect = true;

	if (!reselect) {
		let currentLeft = parseInt(document.getElementById("left").textContent) - 1;
		document.getElementById("left").textContent = currentLeft;
	}
}

function startTimer() {
	let remainingTime = test.time;

	const examTimer = setInterval(() => {
		// Convert remainingTime to a Date object to easily extract hours, minutes, and seconds
		const date = new Date(remainingTime);

		// Format the time as hh:mm:ss
		const hours = date.getUTCHours().toString().padStart(2, "0");
		const minutes = date.getUTCMinutes().toString().padStart(2, "0");
		const seconds = date.getUTCSeconds().toString().padStart(2, "0");

		document.getElementById("hours").textContent = hours;
		document.getElementById("minutes").textContent = minutes;
		document.getElementById("seconds").textContent = seconds;

		remainingTime -= 1000; // Subtract one second from remainingTime

		if (remainingTime < 0 || stopTimer) {
			clearInterval(examTimer);
			submitExam();
		}
	}, 1000);
}

function submitExam() {
	if (submitted) return;
	submitted = true;
	stopTimer = true;
	testForm.style.pointerEvents = "none";
	test.questions.forEach((questionObj) => {
		const radio = document.getElementsByName(`option-${questionObj.id}`);
		const options = [
			{ id: "a", value: questionObj.option_a },
			{ id: "b", value: questionObj.option_b },
			{ id: "c", value: questionObj.option_c },
			{ id: "d", value: questionObj.option_d },
		];

		let attended = false;
		let selectedId = null;

		for (let i = 0; i < radio.length; i++) {
			if (radio[i].checked) {
				attended = true;
				selectedId = radio[i].id;
			}
		}

		if (attended) {
			if (selectedId.split("-")[2] == "a") {
				document
					.getElementById(selectedId)
					.parentElement.classList.add("right");
				test.obtained++;
			} else {
				document
					.getElementById(selectedId)
					.parentElement.classList.add("wrong");
				test.wrong.push(questionObj.id);
			}
		} else test.unattended.push(questionObj.id);

		document
			.getElementById(`option-${questionObj.id}-a`)
			.parentElement.classList.add("correct-ans");
	});
	test.percentage = ((test.obtained / test.marks) * 100).toFixed(2);

	submitToDB();
}

function submitToDB() {
	const submitValue = JSON.stringify({
		id: test.id,
		marks: test.marks,
		wrongs: test.wrong,
		unattended: test.unattended,
	});

	const xhttp = new XMLHttpRequest();
	xhttp.onload = function () {
		if (this.responseText.slice(1, 5).toLowerCase() != "error") {
			const resp = JSON.parse(this.responseText);
			if (resp != false) {
				testPerformance.last = resp[1];
				testPerformance.current = resp[0];
				getPerformanceChange();
			}
			showResult();
		} else console.log(this.responseText);
	};
	xhttp.open("POST", "./scripts/api/tests.api.php");
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(`type=evaluate&test=${submitValue}`);
}

function showResult() {
	const emotions = {
		noChange: ["It's OK"],
		improved: ["Good Job"],
		degrade: ["Uh-Oh"],
	};

	document.getElementById("back-to-top").click();
	testForm.style.display = "none";
	noticeBox.style.display = "block";
	noticeBox.innerHTML = "";

	let emotionResponse = document.createElement("p");
	emotionResponse.id = "emotion";
	noticeBox.appendChild(emotionResponse);

	noticeBox.innerHTML += `<p>You Got <span id="full-marks">${test.obtained}</span> out of <span id="total-marks">${test.marks}</span>.</p>
                <p>Its <span id="percentage">${test.percentage}%</span>.</p>
                <p>Your performance <b id="change">increased</b> by <span id="change-percentage">${testPerformance.delta}%</span>!</p>
				<a href="./user.php" class="btn-anchor">GO TO PROFILE</a>
                <a href="#" class="btn-anchor" onmousedown="showAnswers()">SEE ANSWERS</a>`;
	const performanceMsg = document.getElementById('change');

	emotionResponse = document.getElementById('emotion');
	if (testPerformance.improved == null) {
		emotionResponse.textContent = emotions[Math.floor(Math.random() * (emotions.noChange.length - 1))];
		performanceMsg.textContent = 'changed';
	} else if (testPerformance.improved) {
		emotionResponse.textContent = emotions[Math.floor(Math.random() * (emotions.improved.length - 1))];
		performanceMsg.textContent = 'improved';
		performanceMsg.classList.add('green')
	} else {
		emotionResponse.textContent = emotions[Math.floor(Math.random() * (emotions.degrade.length - 1))];
		performanceMsg.textContent = 'degraded';
		performanceMsg.classList.add('red')
	}
	emotionResponse.textContent += "!";
}

function showAnswers() {
	noticeBox.style.display = "none";
	testForm.style.display = "block";
}

function startExam(marks) {
	noticeBox.style.display = "none";
	test.marks = marks;
	createTest();
	document.getElementById("submit").addEventListener("click", submitExam);
}

// Define a custom sorting function that generates a random value for each element
function randomSort(a, b) {
	return Math.random() - 0.5;
}

function getPerformanceChange() {
	const delta = testPerformance.last - testPerformance.current;
	if (delta > 0) testPerformance.improved = false;
	else if (delta < 0) testPerformance.improved = true;
	testPerformance.delta = ((Math.abs(delta) / testPerformance.last) * 100).toFixed(2);
}
