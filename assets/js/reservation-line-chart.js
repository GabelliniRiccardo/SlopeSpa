$(document).ready(function () {
  console.log('reservations history', reservationsHistory);
  let canvas = document.getElementById('lineChartForReservationsHistory').getContext('2d');
  let lineChartForReservationsHistory = new Chart(canvas, {
    type: 'line',
    data: {
      labels: reservationsHistory.map(({startTime}) => startTime),
      datasets: [{
        label: 'Number of Reservations',
        data: reservationsHistory.map(({numOfReservations}) => numOfReservations),
        backgroundColor: [
          'rgba(54, 162, 235, 0.2)',
        ],
        borderColor: [
          'rgba(54, 162, 235, 1)',
        ],
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
