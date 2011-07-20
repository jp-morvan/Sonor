<!--<audio id="audio" src="<?php echo $sf_request->getAudioPath() ?>empty.<?php echo $sf_request->getAudioFileType() ?>" controls preload></audio>-->
<audio id="audio"  controls ></audio>
<div id="timer"></div>
<button id="previous"><<</button>
<button id="lecture_pause">||</button>
<button id="next">>></button>
<button id="volume_up">+</button>
<button id="volume_down">-</button>
<script type="text/javascript">
//var mySound = new buzz.sound("<?php echo $sf_request->getAudioPath() ?>empty.<?php echo $sf_request->getAudioFileType() ?>");

//var mySound = new buzz.sound("/uploads/audio/list/harder.ogg");
var mySound1 = new buzz.sound("/uploads/audio/list/harder.ogg"),
    mySound2 = new buzz.sound("/uploads/audio/list/burnin.ogg"),
    mySound3 = new buzz.sound("/uploads/audio/list/ensemble.ogg");
var myGroup = new buzz.group(mySound1, mySound2, mySound3);	
myGroup.loop().play().fadeIn()
//    .fadeIn();
//    .loop();
    .bind( "timeupdate", function() {
        var timer = buzz.toTimer( this.getTime() );
        document.getElementById( "timer" ).innerHTML = timer;
    });

$(function() {
  $('#lecture_pause').live('click', function() {
    if(myGroup.sound.paused)
    {
      changePlayPauseButton('pause');
    }
    else
    {
      changePlayPauseButton('play');
    }
    myGroup.togglePlay();
  });
})
function changePlayPauseButton(stateToGo)
{
  var button = $('#lecture_pause');
  if(stateToGo == "pause")
  {
    var text = '||';
  }
  else
  {
    var text = '>';
  }
  button.html(text);
}
/*function test()
{
  var player = document.getElementById('audio');
  var ap = new AudioPlayer(player);
  while(ap.goToNextSong() !== true)
  {
    var wait = ap.getTimeToWaitToTest();
//    pausecomp(wait);
  }
  alert('Chanson suivante !');
}*/
</script>