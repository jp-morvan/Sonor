function show(type, slug)
{
  $.ajax({
    url: '/liste-des-chansons/'+type+'/'+slug,
    success: function(data) {
      $('div#content').html(data);
    }
  });
}

function play(type, slug)
{
  $.ajax({
    url: '/lecture/'+type+'/'+slug,
    success: function(data) {
      $('audio#audio').attr('src', data);
    }
  });
}