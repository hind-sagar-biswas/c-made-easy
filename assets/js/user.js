// Define data
const data = [
	{
		x: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], // Test IDs
		y: [60, 70, 80, 65, 75, 85, 90, 80, 70, 85], // Marks
		customdata: [
			[100, 80],
			[90, 75],
			[85, 100],
			[80, 90],
			[75, 85],
			[120, 100],
			[110, 95],
			[105, 120],
			[100, 110],
			[95, 105],
		],
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
    
}

// Plot the chart
window.addEventListener("load", () => {
    Plotly.newPlot("progress", data, layout, config);
});
