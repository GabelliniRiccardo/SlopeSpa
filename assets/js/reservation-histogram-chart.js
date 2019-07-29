$(document).ready(function () {
  let randomColor = require('randomcolor');
  console.log('operators for histogram', operators);
  let canvas = document.getElementById('histogramChartForOperators').getContext('2d');
  let backgroundColors = [];
  let borderColors = [];
  operators.map((function (operator) {
    backgroundColors.push(randomColor({
      luminosity: 'bright',
      format: 'rgba',
      alpha: 0.2, // e.g. 'rgba(9, 1, 107, 0.2)',
      seed: operator.id + 15
    }));
    borderColors.push(randomColor({
      luminosity: 'bright',
      format: 'rgba',
      alpha: 1, // e.g. 'rgba(9, 1, 107, 1)',
      seed: operator.id + 15,
    }));
  }));

  let histogramChartForOperators = new Chart(canvas, {
    type: 'bar',
    data: {
      labels: operators.map(({firstName, lastName}) => firstName + ' ' + lastName),
      datasets: [{
        label: 'Number of Reservations',
        data: operators.map(({numOfReservations}) => numOfReservations),
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
