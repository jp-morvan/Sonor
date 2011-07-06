function show(type, slug)
{
  $.ajax({
    url: '<?php echo url_for('@show_chansons') ?>/'+type+'/'+slug,
    success: function(data) {
      $('div#content').html(data);
    }
  });
}

function play(type, slug)
{
  $.ajax({
    url: '<?php echo url_for('@play') ?>/'+type+'/'+slug,
    success: function(data) {
      $('audio#audio').attr('src', data);
      $('audio#audio').attr('autoplay', 'autoplay');
    }
  });
}