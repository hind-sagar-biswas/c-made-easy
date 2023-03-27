// URL Parse /////////////////////////////////
const currentUrl = window.location.href;
const url = new URL(currentUrl);
let sl = 1;
if (url.search != "") {
	const serial = parseInt(url.searchParams.get("s"));
	if (Number.isInteger(serial)) sl = serial;
}
///////////////////////////////////////////////

// Req Setup /////////////////////////////////
let type = document.getElementById("file-type").value;
let targetFile = "get_section.inc.php";
///////////////////////////////////////////////

let lastSl = null;
const container = document.getElementById("container");
const loader = document.getElementById("load-cover");

let scriptTag = document.createElement("script");
scriptTag.src = `./assets/prism/prism.js`;
let head = document.getElementsByTagName("head")[0];
head.appendChild(scriptTag);

function togglePreload() {
	loader.classList.toggle("active");
}

function reloadPrism() {
	head.removeChild(scriptTag);
	let newScriptTag = document.createElement("script");
	newScriptTag.src = scriptTag.src;
	head.appendChild(newScriptTag);
	scriptTag = newScriptTag;
}

function reveal(serial) {
	if (lastSl != null) togglePreload();
	if (container.classList.contains("revealed")) return;
	const item = document.getElementById(`sl-${serial}`);

	const xhttp = new XMLHttpRequest();
	xhttp.onload = function () {
		if (this.responseText == "") {
			container.innerHTML = `<div class="mono bold"><span class="red">ERROR:</span> Request for Unknown Topic! Topic with requested id (${sl}) does not exists.</div>`;
			togglePreload();
		} else {
			container.innerHTML = this.responseText;
			item.classList.toggle("revealed");
			if (lastSl != null)
				document.getElementById(`sl-${lastSl}`).classList.toggle("revealed");
			lastSl = serial;
			reloadPrism();
			setTimeout(() => {
				togglePreload();
			}, 300);
		}
	};
	xhttp.open("POST", `./scripts/includes/${targetFile}`);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(`sl=${serial}`);
}

function getFirstProblemId() {

	const xhttp = new XMLHttpRequest();
	xhttp.onload = function () {
		sl = parseInt(this.responseText);
		reveal(sl);
	};
	xhttp.open("POST", `./scripts/includes/${targetFile}`);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(`gf=1`);
}

window.addEventListener("load", () => {
	if (type == "problems") {
		targetFile = "get_solution.inc.php";
		if (sl == 1) getFirstProblemId();
	} else reveal(sl);
	
});
