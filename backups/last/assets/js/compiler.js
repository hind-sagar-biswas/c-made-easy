// URL Parse /////////////////////////////////
const currentUrl = window.location.href;
const url = new URL(currentUrl);
const code = {
	requested: false,
	default: "#include <stdio.h>\r\n\r\nint main() {\r\n    // Your code goes here\r\n    return 0;\r\n}",
	from: null,
	id: null,
};
if (url.search != "") {
	const id = parseInt(url.searchParams.get("try"));
	const from = url.searchParams.get("from");
	if (Number.isInteger(id)) {
		code.requested = true;
		code.from = 'probs';
		code.id = id;
	}
}
///////////////////////////////////////////////

const terminal = document.getElementById("console");
const executor = document.getElementById("execute");
const stdinput = document.getElementById("stdin");

var editor;

function checkDailyLimit() {
	const xhttp = new XMLHttpRequest();
	xhttp.onload = function () {
		console.log(this.responseText);
		const res = JSON.parse(this.responseText);
		if (res.remaining == 0) {
			executor.style.display = "none";
			terminal.innerHTML = `<span class="yellow bold">&gt; </span> <span class="red bold">Daily limit reached! Limit refreshes at 12:00AM UTC.</span>`;
		}
	};
	xhttp.open("POST", "./scripts/includes/jdoodle_limit.inc.php");
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(``);
}

function getRequestedCode() {
	const xhttp = new XMLHttpRequest();
	xhttp.onload = function () {
		const response = JSON.parse(this.responseText);
		if (response.error) editor.setValue(code.default);
		else editor.setValue(response.value);
	};
	xhttp.open("POST", "./scripts/includes/get_code.inc.php");
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(`id=${code.id}&from=${code.from}`);
}

function run(code) {
	code = encodeURIComponent(code);
	let stdin = "";
	if (stdinput.value != "") stdin = `&stdin=${stdinput.value}`;

	const xhttp = new XMLHttpRequest();
	xhttp.onload = function () {
		const res = JSON.parse(this.responseText);
		showOutput(res);
	};
	xhttp.open("POST", "./scripts/includes/compiler.inc.php");
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(`code=${code}${stdin}`);
}

function showOutput(res) {
	const receivedOutput = res.output;
	const output = decodeURIComponent(
		encodeURIComponent(receivedOutput)
			.replace(/%0A/g, "<br>")
			.replace(/%20/g, "&nbsp;")
	);
	const status = res.statusCode;
	const mem = res.memory;
	const cpuTime = res.cpuTime;

	terminal.innerHTML = `<span class="yellow bold">&gt; </span> make -s <br> <span class="yellow bold">&gt; </span> ./main <br> ${output} <br> <span class="grey itallic small">Took ${cpuTime}s to execute.</span>`;
}

// Configure the loader with the base URL for the Monaco Editor scripts
require.config({ paths: { vs: "./vs" } });

// Load the editor
require(["vs/editor/editor.main"], function () {
	// Now the monaco object should be available in the global scope
	monaco.editor.defineTheme("tomorrow-night", {
		base: "vs-dark",
		inherit: true,
		rules: [
			{
				background: "1D1F21",
				token: "",
			},
			{
				foreground: "969896",
				token: "comment",
			},
			{
				foreground: "ced1cf",
				token: "keyword.operator.class",
			},
			{
				foreground: "ced1cf",
				token: "constant.other",
			},
			{
				foreground: "ced1cf",
				token: "source.php.embedded.line",
			},
			{
				foreground: "cc6666",
				token: "variable",
			},
			{
				foreground: "cc6666",
				token: "support.other.variable",
			},
			{
				foreground: "cc6666",
				token: "string.other.link",
			},
			{
				foreground: "cc6666",
				token: "string.regexp",
			},
			{
				foreground: "cc6666",
				token: "entity.name.tag",
			},
			{
				foreground: "cc6666",
				token: "entity.other.attribute-name",
			},
			{
				foreground: "cc6666",
				token: "meta.tag",
			},
			{
				foreground: "cc6666",
				token: "declaration.tag",
			},
			{
				foreground: "cc6666",
				token: "markup.deleted.git_gutter",
			},
			{
				foreground: "de935f",
				token: "constant.numeric",
			},
			{
				foreground: "de935f",
				token: "constant.language",
			},
			{
				foreground: "de935f",
				token: "support.constant",
			},
			{
				foreground: "de935f",
				token: "constant.character",
			},
			{
				foreground: "de935f",
				token: "variable.parameter",
			},
			{
				foreground: "de935f",
				token: "punctuation.section.embedded",
			},
			{
				foreground: "de935f",
				token: "keyword.other.unit",
			},
			{
				foreground: "f0c674",
				token: "entity.name.class",
			},
			{
				foreground: "f0c674",
				token: "entity.name.type.class",
			},
			{
				foreground: "f0c674",
				token: "support.type",
			},
			{
				foreground: "f0c674",
				token: "support.class",
			},
			{
				foreground: "b5bd68",
				token: "string",
			},
			{
				foreground: "b5bd68",
				token: "constant.other.symbol",
			},
			{
				foreground: "b5bd68",
				token: "entity.other.inherited-class",
			},
			{
				foreground: "b5bd68",
				token: "markup.heading",
			},
			{
				foreground: "b5bd68",
				token: "markup.inserted.git_gutter",
			},
			{
				foreground: "8abeb7",
				token: "keyword.operator",
			},
			{
				foreground: "8abeb7",
				token: "constant.other.color",
			},
			{
				foreground: "81a2be",
				token: "entity.name.function",
			},
			{
				foreground: "81a2be",
				token: "meta.function-call",
			},
			{
				foreground: "81a2be",
				token: "support.function",
			},
			{
				foreground: "81a2be",
				token: "keyword.other.special-method",
			},
			{
				foreground: "81a2be",
				token: "meta.block-level",
			},
			{
				foreground: "81a2be",
				token: "markup.changed.git_gutter",
			},
			{
				foreground: "b294bb",
				token: "keyword",
			},
			{
				foreground: "b294bb",
				token: "storage",
			},
			{
				foreground: "b294bb",
				token: "storage.type",
			},
			{
				foreground: "b294bb",
				token: "entity.name.tag.css",
			},
			{
				foreground: "ced2cf",
				background: "df5f5f",
				token: "invalid",
			},
			{
				foreground: "ced2cf",
				background: "82a3bf",
				token: "meta.separator",
			},
			{
				foreground: "ced2cf",
				background: "b798bf",
				token: "invalid.deprecated",
			},
			{
				foreground: "ffffff",
				token: "markup.inserted.diff",
			},
			{
				foreground: "ffffff",
				token: "markup.deleted.diff",
			},
			{
				foreground: "ffffff",
				token: "meta.diff.header.to-file",
			},
			{
				foreground: "ffffff",
				token: "meta.diff.header.from-file",
			},
			{
				foreground: "718c00",
				token: "markup.inserted.diff",
			},
			{
				foreground: "718c00",
				token: "meta.diff.header.to-file",
			},
			{
				foreground: "c82829",
				token: "markup.deleted.diff",
			},
			{
				foreground: "c82829",
				token: "meta.diff.header.from-file",
			},
			{
				foreground: "ffffff",
				background: "4271ae",
				token: "meta.diff.header.from-file",
			},
			{
				foreground: "ffffff",
				background: "4271ae",
				token: "meta.diff.header.to-file",
			},
			{
				foreground: "3e999f",
				fontStyle: "italic",
				token: "meta.diff.range",
			},
		],
		colors: {
			"editor.foreground": "#C5C8C6",
			"editor.background": "#1D1F21",
			"editor.selectionBackground": "#373B41",
			"editor.lineHighlightBackground": "#282A2E",
			"editorCursor.foreground": "#AEAFAD",
			"editorWhitespace.foreground": "#4B4E55",
		},
	});

	editor = monaco.editor.create(document.getElementById("editor"), {
		language: "c",
		theme: "tomorrow-night",
		automaticLayout: true,
		wordWrap: "on",
	});
});

window.addEventListener("load", () => {
	checkDailyLimit();
	executor.addEventListener("click", () => {
		const code = editor.getValue();
		run(code);
	});
	if (!code.requested) editor.setValue(code.default);
	else getRequestedCode();
});
