import 'bootstrap';

$(document).ready(function () {

  var form = $('form[name="create_reservation_form"]');
  let treatment = $("#create_reservation_form_reservation_treatment");
  let operator = $("#create_reservation_form_reservation_operator");
  treatment.prop('disabled', true);
  operator.prop('disabled', true);

  $(document).on('change',
    '#create_reservation_form_reservation_start_time,' +
    '#create_reservation_form_reservation_treatment, ' +
    '#create_reservation_form_reservation_operator',
    '#create_reservation_form_reservation_treatment,' +
    '#create_reservation_form_reservation_operator', function () {
      console.log('changed!');

      let startTimeMonth = $("#create_reservation_form_reservation_start_time_date_month");
      let startTimeDay = $("#create_reservation_form_reservation_start_time_date_day");
      let startTimeYear = $("#create_reservation_form_reservation_start_time_date_year");
      let startTimeHour = $("#create_reservation_form_reservation_start_time_time_hour");
      let startTimeMinute = $("#create_reservation_form_reservation_start_time_time_minute");

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
            form = $('form[name="create_reservation_form"]');
            $('#AjaxModal').fadeOut(function () {
              $('#AjaxModal').modal('hide');
            });
            let treatment = $("#create_reservation_form_reservation_treatment");
            let operator = $("#create_reservation_form_reservation_operator");

            if (!treatment.val()) {
              operator.prop('disabled', true);
            }
          }
        });
      }
    });
});
