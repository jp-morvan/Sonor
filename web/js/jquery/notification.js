var myMessages = ['info','warning','error','success'];

function hideAllMessages()
{
  var messagesHeights = new Array(); // this array will store height for each

  for (i=0; i<myMessages.length; i++)
  {
    var container = $('.'+myMessages[i]);
    container.stop();
    messagesHeights[i] = container.outerHeight(); // fill array
    container.css('top', -messagesHeights[i]); //move element outside viewport
    container.html('');
  }
  messagesHeights = null;
}

function showMessage(type, msg)
{
  hideAllMessages();
  var container = $('.'+type);
  if(msg != null)
  {
    container.html(msg);
  }
  container.animate({top:"0"}, 1000).delay(1000).animate({top:"-40"}, 2000);
}

$(document).ready(function(){
  hideAllMessages();     
});