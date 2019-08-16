import {BaseClient} from "./BaseClient";
import Color from '../../services/Color'

class ReservationsClient extends BaseClient {

  constructor() {
    super('/reservations/');
  }

  getCalendarReservations(date) {

    let randomColor = require('randomcolor');
    let calendarReservations = [];

    $.ajax({
      type: 'GET',
      url: this.url,
      data: {date: date.toJSON().slice(0, 10).replace(/-/g, '/')}
    }).done(function (response) {
      response.forEach(function (element) {
        calendarReservations.push({ // add new event data
          resourceId: element.operatorId,
          title: element.name,
          start: element.start.date,
          end: element.end.date,
          color: new Color(element.operatorId, 0.4, 'bright').color,
          borderColor: new Color(element.operatorId, 1, 'bright').color,
          reservationId: element.id,
          operatorId: element.operatorId,
          operatorFirstName: element.operatorFirstName,
          operatorLastName: element.operatorLastName,
          customerFirstName: element.customerFirstName,
          customerLastName: element.customerLastName,
          price: element.price.value + ' ' + element.price.currency,
          allDay: false
        })
      });
    }).fail(function (response) {
      console.error('Ajax request for reservations fail');
    });

    return calendarReservations;
  }

  deleteReservation(id, errorCallback, successCallback) {
    $.ajax({
        url: '/staff/calendar/reservation/delete/' + id,
        type: 'DELETE',
        error: errorCallback,
        success: successCallback
      }
    )
  }
}

export const reservationsClient = new ReservationsClient();
