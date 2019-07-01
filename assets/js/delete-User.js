var loadingContent = $('#loadingModalDialog').html();

$(".deleteButton").click(function (e) {
  e.preventDefault();
  var id = $(this).attr('id');
  var url = '/admin/staff/delete/' + id;

  $('#loadModalContent').replaceWith(loadingContent);

  $.get(url, function (content) {
    content = $.parseHTML(content);
    $('#loadModalContent').replaceWith(content);
  })
    .fail(function () {
      console.error('Ajax request for user id ' + id + ' error')
    })
    .done(function () {
      console.log('Ajax request for user id ' + id + ' success');
    });
});
