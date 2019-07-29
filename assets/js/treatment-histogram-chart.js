$(document).ready(function () {
  let randomColor = require('randomcolor');
  console.log('treatments', treatments);
  let canvas = document.getElementById('histogramChartForTreatments').getContext('2d');
  let backgroundColors = [];
  let borderColors = [];
  treatments.map((function (treatment) {
    backgroundColors.push(randomColor({
      luminosity: 'bright',
      format: 'rgba',
      alpha: 0.2, // e.g. 'rgba(9, 1, 107, 0.2)',
      seed: treatment.id + 15
    }));
    borderColors.push(randomColor({
      luminosity: 'bright',
      format: 'rgba',
      alpha: 1, // e.g. 'rgba(9, 1, 107, 1)',
      seed: treatment.id + 15,
    }));
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
