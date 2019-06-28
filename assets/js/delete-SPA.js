var loadingContent = $('.modal-dialog').html();

$(".deleteButton").click(function (e) {
  e.preventDefault();
  var id = $(this).attr('id');
  var url = '/admin/spa/delete/' + id;

  $('.modal-content').replaceWith(loadingContent);

  $.get(url, function (content) {
    content = $.parseHTML(content);
    $('.modal-content').replaceWith(content);
  })
    .fail(function () {
      console.error('Ajax request for spa id ' + id + ' error')
    })
    .done(function () {
      console.log('Ajax request for spa id ' + id + ' success');
    });
});

