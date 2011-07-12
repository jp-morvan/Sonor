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

$(function() {
  $('img.delete').live('click', function() {
    var img = $(this);
    var id = $(this).attr('id').split("_");
    var type = id[1];
    var slug = id[2]+"_"+id[3];
    var _type = type.charAt(0).toUpperCase() + type.substring(1).toLowerCase();
    confirm("Confirmer la suppression ?", _type+" - Suppression", function(r) {
      if(r){
        $.ajax({
          url: '<?php echo url_for('@remove') ?>/'+type+'/'+slug,
          success: function(data) {
            $(img).parent('li').remove();
          }
        });
      }
    });
    return false;
  });
});

$(function() {
  $('img.add').live('click', function() {
    var img = $(this);
    var id = $(this).attr('id').split("_");
    var type = id[1];
    var _type = type.charAt(0).toUpperCase() + type.substring(1).toLowerCase();
    var field = null;
    if(type == 'album')
    {
      field = function(){
         $.ajax({
          url: '<?php echo url_for('@get_album_field') ?>',
          success: function(data) {
            return data;
          }
        });
      };
    }
    /*prompt('Titre', '', _type+" - Ajout", function(r) {
      if(r != null){
        $.ajax({
          url: '<?php echo url_for('@add') ?>/'+type+'/'+r,
          success: function(data) {
            $("ul#"+type+"s_list").append(data);
          }
        });
      }
    }, field);*/
    return false;
  });
});

//alert()  
var oAlert = alert;  
function alert(txt, title) {  
    try {  
        if(title == null) title = '';
        jAlert(txt, title);  
    } catch (e) {  
        oAlert(txt);  
    }  
}  

//confirm()  
var oConfirm = confirm;  
function confirm(txt, title, func) {  
    try {  
        if(title == null) title = '';
        jConfirm(txt, title, func);  
    } catch (e) {  
        if (oConfirm (txt, title)) func();  
    }  
}  

//prompt()  
var oPrompt = prompt;  
function prompt(txt, input, title, func){  
    try {  
        if(title == null) title = '';
        jPrompt(txt, input, title, func);  
    } catch(e) {  
        func(prompt(txt, input, title));  
    }  
}  