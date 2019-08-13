import Color from './services/Color'

$(document).ready(function () {
  console.log('treatments', treatments);
  let canvas = document.getElementById('histogramChartForTreatments').getContext('2d');
  let backgroundColors = [];
  let borderColors = [];
  treatments.map((function (treatment) {
    backgroundColors.push(
      new Color(treatment.id, 0.4, 'bright').color
    );
    borderColors.push(
      new Color(treatment.id, 1, 'bright').color
    );
  }));
  let histogramChartForTreatments = new Chart(canvas, {
    type: 'bar',
    data: {
      labels: treatments.map(({name}) => name),
      datasets: [{
        data: treatments.map(({numOfReservations}) => numOfReservations),
        backgroundColor: backgroundColors,
        borderColor: borderColors,
        borderWidth: 1
      }]
    },
    options: {
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });
});
