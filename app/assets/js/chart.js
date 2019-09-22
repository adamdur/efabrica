let ctx = document.querySelector('#employeesChart');
let data = ctx.getAttribute('data-age').split(',');

let counts = {};
for (let x of data) {
	counts[x] = (counts[x] || 0)+1;
}

let chart = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: Object.keys(counts),
		datasets: [{
			label: 'Overview of the age of employees',
			data: Object.values(counts),
			backgroundColor:'rgba(54, 162, 235, 0.2)',
			borderColor: 'rgba(54, 162, 235, 1)',
			borderWidth: 2
		}]
	},
	responsive: true,
	options: {
		scales: {
			yAxes: [{
				stacked: true,
				ticks: {
					beginAtZero: true
				},
				scaleLabel: {
					display: true,
					labelString: 'Number of employees with the certain age'
				}
			}],
			xAxes: [{
				barPercentage: 0.7,
				gridLines: {
					offsetGridLines: true
				},
				scaleLabel: {
					display: true,
					labelString: 'Age of employees'
				}
			}]
		},
	}
});