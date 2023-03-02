var lastSl = null;
const container = document.getElementById("container");
const loader = document.getElementById("load-cover");

var scriptTag = document.createElement("script");
scriptTag.src = `./assets/prism/prism.js`;
var head = document.getElementsByTagName("head")[0];
head.appendChild(scriptTag);

function togglePreload() {
	loader.classList.toggle('active');
}

function reloadPrism() {
	head.removeChild(scriptTag);
	var newScriptTag = document.createElement("script");
	newScriptTag.src = scriptTag.src;
	head.appendChild(newScriptTag);
	scriptTag = newScriptTag;
}

function reveal(serial, id) {
	if (lastSl != null) togglePreload();
	if (container.classList.contains("revealed")) return;
	const item = document.getElementById(`sl-${serial}`);

	const xhttp = new XMLHttpRequest();
	xhttp.onload = function () {
		if (this.responseText == "0") {
			alert("Something went wrong!");
		} else {
			container.innerHTML = this.responseText;
			item.classList.toggle("revealed");
			if (lastSl != null)
				document.getElementById(`sl-${lastSl}`).classList.toggle("revealed");
			lastSl = serial;
			reloadPrism();
			setTimeout(() => {
				togglePreload();
			}, 2000);
		}
	};
	xhttp.open("POST", "./scripts/includes/get_section.php");
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(`id=${id}`);
}

window.addEventListener("load", () => {
	reveal(1, 1);
});
