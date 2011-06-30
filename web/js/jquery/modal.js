$(function() {
  $('img.show').click(function() {
    $("#dialog").html($("div#content_"+this.id).html());
    $("#dialog").dialog({
      autoOpen: true,
      modal: true,
      resizable: false,
      width: 400,
      beforeclose: function() {
        $(this).html('');
      },
      position: 'center'
    });
    return false;
  });
});
