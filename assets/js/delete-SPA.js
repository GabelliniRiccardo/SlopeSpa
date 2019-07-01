var loadingContent = $('#loadingModalDialog').html();

$(".deleteButton").click(function (e) {
  e.preventDefault();
  var id = $(this).attr('id');
  var url = '/admin/spa/delete/' + id;

  $('#loadModalContent').replaceWith(loadingContent);

  $.get(url, function (content) {
    content = $.parseHTML(content);
    $('#loadModalContent').replaceWith(content);
  })
    .fail(function () {
      console.error('Ajax request for spa id ' + id + ' error')
    })
    .done(function () {
      console.log('Ajax request for spa id ' + id + ' success');
    });
});
