var loadingContent = $('#loadingModalDialog').html();

$(".deleteButton").click(function (e) {
  e.preventDefault();
  var id = $(this).attr('id');
  var url = '/staff/reservation/delete/' + id;

  $('#loadModalContent').replaceWith(loadingContent);

  $.get(url, function (content) {
    content = $.parseHTML(content);
    $('#loadModalContent').replaceWith(content);
  })
    .fail(function () {
      console.error('Ajax request for reservation id ' + id + ' error')
    })
    .done(function () {
      console.log('Ajax request for reservation id ' + id + ' success');
    });
});
