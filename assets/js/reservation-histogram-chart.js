import Color from './services/Color'

$(document).ready(function () {

  console.log('operators for histogram', operators);
  let canvas = document.getElementById('histogramChartForOperators').getContext('2d');
  let backgroundColors = [];
  let borderColors = [];
  operators.map((function (operator) {
    backgroundColors.push(
      new Color(operator.id, 0.4, 'bright').color
    );
    borderColors.push(
      new Color(operator.id, 1, 'bright').color
    )
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
