$(document).ready(function () {

  //AJAX LIKE POST
  $('.likePost').on('click', function () {
    var id = $(this).attr('id');
    $('#' + id + ' .removeLike2').toggle();
    $('#' + id + ' .addLike2').toggle().removeClass("hidden");
    $('#' + id + ' .addLike').toggle();
    $('#' + id + ' .removeLike').toggle().removeClass("hidden");
    $.ajax({
      type: 'POST',
      url: Routing.generate('post_like_new', {id: id}),
      dataType: "json",
      success: function (data) {
        $('#post' + id).html(data);
      }
    });
  });


});


$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
