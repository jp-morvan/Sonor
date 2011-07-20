<!--<audio id="audio" src="<?php echo $sf_request->getAudioPath() ?>empty.<?php echo $sf_request->getAudioFileType() ?>" controls preload></audio>-->
<div id="player">
  <img id="previous" src="/images/player/previous.png" />
  <img id="lecture_pause" src="/images/player/play-48.png" />
  <img id="stop" src="/images/player/stop.png" />
  <img id="next" src="/images/player/next.png" />
  <div id="timer"></div>
</div>
<div id="bloc_volume">
  <img id="volume_down" src="/images/player/vol-down.png" />
  <img id="volume_up" src="/images/player/vol-up2.png" />
  <img id="mute" src="/images/player/mute.png" />
  <span id="volume"></span>
</div>
<script type="text/javascript">
//var mySound = new buzz.sound("<?php echo $sf_request->getAudioPath() ?>empty.<?php echo $sf_request->getAudioFileType() ?>");

var mySound = new buzz.sound("<?php echo $sf_request->getAudioPath() ?>empty.<?php echo $sf_request->getAudioFileType() ?>")
                        .bind( "timeupdate", function() {
                            $("#timer").html(buzz.toTimer( this.getTime() ));
                        })
                        .bind("volumechange", function() {
                            $("#volume").html(this.getVolume()+"%");
                        });
//var mySound1 = new buzz.sound("<?php echo $sf_request->getAudioPath() ?>empty.<?php echo $sf_request->getAudioFileType() ?>");
//    mySound2 = new buzz.sound("/uploads/audio/list/burnin.ogg"),
//    mySound3 = new buzz.sound("/uploads/audio/list/ensemble.ogg");
//var myGroup = new buzz.group(mySound1, mySound2, mySound3);	
//var myGroup = new buzz.group(mySound1);	
//myGroup.loop().play().fadeIn()
//    .fadeIn();
//    .loop();
//    .bind( "timeupdate", function() {
//        var timer = buzz.toTimer( this.getTime() );
//        document.getElementById( "timer" ).innerHTML = timer;
//    });

$(function() {
  // STOP
  $('#stop').live('click', function() {
    mySound.stop();
    changePlayPauseButton('play');
  });
  // PLAY & PAUSE
  $('#lecture_pause').live('click', function() {
    if(mySound.sound.paused)
    {
      changePlayPauseButton('pause');
    }
    else
    {
      changePlayPauseButton('play');
    }
    mySound.togglePlay();
  });
  // MUTE
  var oldVolume = null;
  $('#mute').live('click', function() {
//    var volume = mySound.getVolume();
//    if(volume > 0)
//    {
//      oldVolume = volume;
//      mySound.setVolume(0);
//    }
//    else
//    {
//      mySound.setVolume(oldVolume);
//    }
    mySound.toggleMute();
  });
  // VOLUME UP
  $('#volume_up').live('click', function() {
    mySound.increaseVolume(20);
  });
  // VOLUME DOWN
  $('#volume_down').live('click', function() {
    mySound.decreaseVolume(20);
  });
});

function changePlayPauseButton(stateToGo)
{
  var button = $('#lecture_pause');
  if(stateToGo == "pause")
  {
    var img = '/images/player/pause-48.png';
  }
  else
  {
    var img = '/images/player/play-48.png';
  }
  button.attr('src', img);
}
</script>