import tippy from 'tippy.js'

export default class Tooltip {

  setInfo(info) {
    tippy(info.el, {
      placement: 'top',
      content:
        'Massage: ' + info.event.title + '<br/>' +
        'Customer: ' + info.event._def.extendedProps.customerFirstName + ' ' + info.event._def.extendedProps.customerLastName + '<br/>' +
        'Start Time: ' + info.event.start.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'}) + '<br/>' +
        'End Time: ' + info.event.end.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'}),
      arrow: true,
      animation: 'shift-away',
      delay: [500, 200], // ms to show and ms to hide
      arrowType: 'round',
    });
  }
}
