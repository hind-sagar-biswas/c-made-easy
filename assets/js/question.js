// Select the form container and the add new button
const questionForm = document.querySelector("#question-form");
const addNewBtn = document.querySelector("#add-new");
const submitBtn = document.querySelector("#submit");

// Initialize question count
let questionCount = 2;

// Function to add a new question section to the form
function addNewQues() {
	// Create a new question section
	const newQuesSection = document.createElement("div");
	newQuesSection.classList.add("form-section");

	// Create textarea for the question
	const quesTextarea = document.createElement("textarea");
	quesTextarea.name = `question-${questionCount}`;
	quesTextarea.id = `question-${questionCount}`;
	quesTextarea.cols = "30";
	quesTextarea.rows = "10";
	newQuesSection.appendChild(quesTextarea);

	// Create input fields for the options
	for (let i = 1; i <= 4; i++) {
		const optionInput = document.createElement("input");
		optionInput.type = "text";
		optionInput.placeholder = `option ${String.fromCharCode(96 + i)}`;
		optionInput.name = `question-${questionCount}-option-${String.fromCharCode(
			96 + i
		)}`;
		optionInput.id = `question-${questionCount}-option-${String.fromCharCode(
			96 + i
		)}`;
		optionInput.required = true;
		newQuesSection.appendChild(optionInput);
	}

	// Create radio feild for board question
	const radioInput = document.createElement("input");
	radioInput.type = "checkbox";
	radioInput.name = `question-${questionCount}-board`;
	radioInput.id = `question-${questionCount}-board`;
	radioInput.required = true;
	newQuesSection.appendChild(radioInput);
	// Create radio feild label for board question
	const radioLabelInput = document.createElement("label");
	radioLabelInput.for = `question-${questionCount}-board`;
	radioLabelInput.value = `1`;
	radioLabelInput.innerText = `board question`;
	newQuesSection.appendChild(radioLabelInput);

	// Append the new question section to the form
	questionForm.appendChild(newQuesSection);

	// Increment the question count
	questionCount++;
}

function createQuestionArray() {
	const formSections = document.querySelectorAll(".form-section");
	const questions = [];
	formSections.forEach((section) => {
		const questionObj = {
			question: section.querySelector("textarea").value,
			optionA: section.querySelector("input[name$='-option-a']").value,
			optionB: section.querySelector("input[name$='-option-b']").value,
			optionC: section.querySelector("input[name$='-option-c']").value,
			optionD: section.querySelector("input[name$='-option-d']").value,
			board: section.querySelector("input[name$='-board']").checked ? 1 : 0,
		};
		questions.push(questionObj);
	});
	return JSON.stringify(questions);
}

function resetAll() {
	questionCount = 1;
	while (questionForm.firstChild) {
		questionForm.removeChild(questionForm.firstChild);
	}
	addNewQues();
}

function submitAll() {
	const questionArray = encodeURIComponent(createQuestionArray());
	const xhttp = new XMLHttpRequest();
	xhttp.onload = function () {
		const resp = this.responseText;
		document.getElementById("log").innerHTML = resp;
		resetAll();
	};
	xhttp.open("POST", "./scripts/includes/add_questions.inc.php");
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(`ques=${questionArray}`);
}

// Add click event listener to the buttons
addNewBtn.addEventListener("click", addNewQues);
submitBtn.addEventListener("click", submitAll);
