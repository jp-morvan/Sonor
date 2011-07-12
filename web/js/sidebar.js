$(function() {
  $('img.delete').click(function() {
    var id = $(this).attr('id').split("_");
    var type = id[1];
    var slug = id[2];
    if (confirm("Supprimer ?")){
      $.ajax({
//        url: '<?php echo url_for('@show_chansons') ?>/'+type+'/'+slug,
        success: function(data) {
          $(this).parent('li').remove();
        }
      });
    }
    return false;
  });
});
