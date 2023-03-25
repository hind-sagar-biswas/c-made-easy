// URL Parse /////////////////////////////////
const currentUrl = window.location.href;
const url = new URL(currentUrl);
const requestedUser = url.search != "" ? url.searchParams.get("u") : "__SELF__";
///////////////////////////////////////////////

// Define data
const data = [
	{
		x: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], // Test IDs
		y: [], // Marks
		customdata: [],
		hovertemplate: "Obtained: %{customdata[0]}<br>Total: %{customdata[1]}",
		mode: "lines+markers",
	},
];

// Define layout
const layout = {
	title: "Test Progress",
	xaxis: {
		type: "linear",
		tickfont: {
			color: "#0ba1d4",
		},
	},
	yaxis: {
		title: "Marks (%)",
		tickfont: {
			color: "#0ba1d4",
		},
	},
	margin: {
		l: 50,
		r: 50,
		t: 50,
		b: 50,
	},
	font: {
		family: "Arial, sans-serif",
		size: 14,
		color: "#ffffff",
	},
	paper_bgcolor: "rgb(0, 0, 0)",
	plot_bgcolor: "rgb(0, 0, 0)",
	hovermode: "closest",
	showlegend: false,
};

const config = {
	displayModeBar: false,
	scrollZoom: false,
};

// USER DATA

// FETCH USER DATA
function getUserTestDetails() {
	const xhttp = new XMLHttpRequest();
	xhttp.onload = function () {
		if (this.responseText.slice(1, 5).toLowerCase() != "error") {
			console.log(this.responseText);
			const resp = JSON.parse(this.responseText);
			data[0].y = resp.marks;
			data[0].customdata = resp.obtained_n_total;
			Plotly.newPlot("progress", data, layout, config);
		} else console.log(this.responseText);
	};
	xhttp.open("POST", "./scripts/api/tests.api.php");
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(`type=user_data&u=${requestedUser}`);
}

// Plot the chart
if (screen.width < 500) {
	layout.xaxis.title = null;
	layout.yaxis.title = null;
}
getUserTestDetails();
