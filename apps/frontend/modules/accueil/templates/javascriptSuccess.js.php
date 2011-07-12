function show(type, slug)
{
  $.ajax({
    url: '<?php echo url_for('@show_chansons') ?>/'+type+'/'+slug,
    success: function(data) {
      $('div#content').html(data);
    }
  });
}

function updateInList(type, slug, acte)
{
  $.ajax({
    url: '<?php echo url_for('@update_in_list') ?>/'+acte+'/'+type+'/'+slug,
    success: function(data) {
      $('div#album_in_list').html(data);
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
    if(id[4] != null)
    {
      var img = $('#'+id[0]+'_'+id[1]+'_'+id[2]+'_'+id[3]);
    }
    var _type = type.charAt(0).toUpperCase() + type.substring(1).toLowerCase();
    confirm("Confirmer la suppression ?", _type+" - Suppression", function(r) {
      if(r){
        $.ajax({
          url: '<?php echo url_for('@remove') ?>/'+type+'/'+slug,
          success: function(data) {
            img.parent('li').remove();
            updateInList(type, slug, 'supprimer');
            showMessage('success', '<h1>'+_type+' supprimé(e) de votre musique avec succès !</h1>');
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
    var slug = id[2];
    var _type = type.charAt(0).toUpperCase() + type.substring(1).toLowerCase();
    if(type == 'playlist')
    {
      prompt('Titre', '', _type+" - Ajout", function(r) {
        if(r != null){
          $.ajax({
            url: '<?php echo url_for('@add') ?>/'+type+'/'+r,
            success: function(data) {
              $("ul#"+type+"s_list").append(data);
              updateInList(type, r, 'ajouter');
              showMessage('success', '<h1>Playlist "'+r+'" créée avec succès !</h1>');
            }
          });
        }
      });
    }
    else
    {
      $.ajax({
        url: '<?php echo url_for('@add') ?>/'+type+'/'+slug,
        success: function(data) {
          $("ul#"+type+"s_list").append(data);
          updateInList(type, slug, 'ajouter');
          showMessage('success', '<h1>Album ajouté à votre musique avec succès !</h1>');
        }
      });
    }
    return false;
  });
});

// TODO vérifier si 250ms suffisent ou s'il faut augmenter
$(function() {
  $('input#autocomplete_recherche').change(function() {
    var x = setTimeout(function(){
      var content = $('input#recherche').val().split("_");
      var type = content[0];
      var slug = content[1];
      if(type == "a")
      {
        show('album', slug);
      }
      if(type == "c")
      {
        show('chanson', slug);
      }
    }, 250);
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
function prompt(txt, input, title, func, field){  
    try {  
        if(title == null) title = '';
        jPrompt(txt, input, title, func, field);  
    } catch(e) {  
        func(prompt(txt, input, title));  
    }  
}