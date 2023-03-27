const form = document.getElementById("solution-form");
const addNewBtn = document.querySelector("#add-new");
const submitBtn = document.querySelector("#submit");

let solutionCount = 2;

function addNewSol() {
	const formSection = document.createElement("div");
	formSection.classList.add("form-section");

	const titleInput = document.createElement("input");
	titleInput.type = "text";
	titleInput.name = `solution-${solutionCount}-title`;
	titleInput.id = `solution-${solutionCount}-title`;
	titleInput.placeholder = "title";
	titleInput.required = true;
	formSection.appendChild(titleInput);

	const problemTextarea = document.createElement("textarea");
	problemTextarea.name = `solution-${solutionCount}-problem`;
	problemTextarea.id = `solution-${solutionCount}-problem`;
	problemTextarea.placeholder = "problem";
	problemTextarea.required = true;
	formSection.appendChild(problemTextarea);

	const exampleInputInput = document.createElement("input");
	exampleInputInput.type = "text";
	exampleInputInput.name = `solution-${solutionCount}-example-input`;
	exampleInputInput.id = `solution-${solutionCount}-example-input`;
	exampleInputInput.placeholder = "input";
	exampleInputInput.required = true;
	formSection.appendChild(exampleInputInput);

	const expectedOutputInput = document.createElement("input");
	expectedOutputInput.type = "text";
	expectedOutputInput.name = `solution-${solutionCount}-expected-output`;
	expectedOutputInput.id = `solution-${solutionCount}-expected-output`;
	expectedOutputInput.placeholder = "output";
	expectedOutputInput.required = true;
	formSection.appendChild(expectedOutputInput);

	const approachTextarea = document.createElement("textarea");
	approachTextarea.name = `solution-${solutionCount}-approach`;
	approachTextarea.id = `solution-${solutionCount}-approach`;
	approachTextarea.placeholder = "approach";
	formSection.appendChild(approachTextarea);

	const algorithmTextarea = document.createElement("textarea");
	algorithmTextarea.name = `solution-${solutionCount}-algorithm`;
	algorithmTextarea.id = `solution-${solutionCount}-algorithm`;
	algorithmTextarea.placeholder = "algo";
	algorithmTextarea.rows = "5";
	formSection.appendChild(algorithmTextarea);

	const codeTextarea = document.createElement("textarea");
	codeTextarea.name = `solution-${solutionCount}-code`;
	codeTextarea.id = `solution-${solutionCount}-code`;
	codeTextarea.placeholder = "code";
	codeTextarea.rows = "5";
	formSection.appendChild(codeTextarea);

	const explanationTextarea = document.createElement("textarea");
	explanationTextarea.name = `solution-${solutionCount}-explanation`;
	explanationTextarea.id = `solution-${solutionCount}-explanation`;
	explanationTextarea.placeholder = "exp";
	explanationTextarea.rows = "5";
	formSection.appendChild(explanationTextarea);

	const difficultySelect = document.createElement("select");
	difficultySelect.name = `solution-${solutionCount}-difficulty`;
	difficultySelect.id = `solution-${solutionCount}-difficulty`;
	formSection.appendChild(difficultySelect);

	const difficulties = ["beginer", "intermediate", "advanced"];
	for (let dif = 0; dif < difficulties.length; dif++) {
		const difficulty = difficulties[dif];
		const difficultyOption = document.createElement("option");
		difficultyOption.value = `${difficulty}`;
		difficultyOption.textContent = `${difficulty}`;
		difficultySelect.appendChild(difficultyOption);
	}

	const tagsInput = document.createElement("input");
	tagsInput.type = "text";
	tagsInput.name = `solution-${solutionCount}-tags`;
	tagsInput.id = `solution-${solutionCount}-tags`;
	tagsInput.placeholder = "tags";
	tagsInput.required = true;
	formSection.appendChild(tagsInput);

	form.appendChild(formSection);

	solutionCount++;
}

function createStepsList(steps) {
	steps = decodeURIComponent(encodeURIComponent(steps).replace(/%0A/g, "\n"));
	let stepList = "";

	steps.split("\n").forEach((step) => {
		if (step.trim() !== "") {
			const li = `<li>${step.trim()}</li>`;
			stepList += li;
		}
	});

	return stepList;
}

function resetAll() {
	solutionCount = 1;
	while (form.firstChild) {
		form.removeChild(form.firstChild);
	}
	addNewSol();
}

function getSolutionInputs() {
	const solutionForms = document.querySelectorAll(".form-section");
	const solutions = [];

	solutionForms.forEach((form) => {
		const inputs = form.querySelectorAll("input, textarea, select");
		const solution = {};

		inputs.forEach((input) => {
			let key = input.name;
			let value = input.value;

			const [, , ...parts] = key.split("-");
			key = parts.join("-");
			if (key == "algorithm" || key == "explanation") value = createStepsList(value);
			else if(key == "code") value = value;
			else if (key == "tags") value = JSON.stringify(value.split(", "));

			solution[key] = value;
		});

		solutions.push(solution);
	});

	return solutions;
}

function submit() {
	const solutionArray = encodeURIComponent(JSON.stringify(getSolutionInputs()));

	const xhttp = new XMLHttpRequest();
	xhttp.onload = function () {
		const resp = this.responseText;
		document.getElementById("log").innerHTML = resp;
		// resetAll();
	};
	xhttp.open("POST", "./scripts/includes/add_solutions.inc.php");
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(`sol=${solutionArray}`);
}

window.addEventListener("load", () => {
	addNewBtn.addEventListener("click", addNewSol);
	submitBtn.addEventListener("click", submit);
});
