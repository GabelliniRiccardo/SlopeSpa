import 'bootstrap';

$(document).ready(function () {

  var form = $('form[name="edit_reservation_form"]');

  $.ajax({
    type: 'POST',
    url: form.attr('action'),
    data: form.serialize(),
    success: function (response) {
      form.replaceWith(response);
      form = $('form[name="edit_reservation_form"]');
      $('#AjaxModal').fadeOut(function () {
        $('#AjaxModal').modal('hide');
      });
    }
  });

  $(document).on('change',
    '#edit_reservation_form_reservation_start_time,' +
    '#edit_reservation_form_reservation_treatment, ' +
    '#edit_reservation_form_reservation_operator',
    '#edit_reservation_form_reservation_treatment,' +
    '#edit_reservation_form_reservation_operator', function () {
      console.log('changed!');

      let startTimeMonth = $("#edit_reservation_form_reservation_start_time_date_month");
      let startTimeDay = $("#edit_reservation_form_reservation_start_time_date_day");
      let startTimeYear = $("#edit_reservation_form_reservation_start_time_date_year");
      let startTimeHour = $("#edit_reservation_form_reservation_start_time_time_hour");
      let startTimeMinute = $("#edit_reservation_form_reservation_start_time_time_minute");

      if (startTimeMonth.val() && startTimeDay.val() &&
        startTimeYear.val() && startTimeHour.val() &&
        startTimeMinute.val()) {

        $('#AjaxModal').fadeIn();
        $('#AjaxModal').modal('show');
        $.ajax({
          type: 'POST',
          url: form.attr('action'),
          data: form.serialize(),
          success: function (response) {
            form.replaceWith(response);
            form = $('form[name="edit_reservation_form"]');
            $('#AjaxModal').fadeOut(function () {
              $('#AjaxModal').modal('hide');
            });
          }
        });
      }
    });
});
