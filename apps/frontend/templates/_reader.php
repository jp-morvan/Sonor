<!--<audio id="audio" src="<?php echo $sf_request->getAudioPath() ?>empty.<?php echo $sf_request->getAudioFileType() ?>" controls preload></audio>-->
<div id="player">
  <div id="controls">
    <div id="buttons">
    <img id="previous" src="/images/player/previous.png" />
    <img id="play_pause" src="/images/player/play-48.png" />
<!--    <img id="stop" src="/images/player/stop.png" />-->
    <img id="next" src="/images/player/next.png" />
    </div>
    <div id="bloc_volume">
      <img id="mute_unmute" src="/images/player/mute.png" />
      <div id="volume_slider"></div>
      <div id="volume"></div>
    </div>
  </div>
  <div id="bloc_player">
    <div id="artiste">Artiste</div> - 
    <div id="title">Titre de la chanson</div>
    <div id="time_slider"></div>
    <div id="timer"></div>
  </div>
</div>
<div id="test"></div>
<script type="text/javascript">
  
$(function() {
  // SLIDER DU VOLUME
  $( "#volume_slider" ).slider({
    range: "min",
    value: 80,
    min: 0,
    max: 100,
    step: 5,
    slide: function( event, ui ) {
      $( "#volume" ).html(ui.value + "%");
    }
  });
  $( "#volume" ).html( $( "#volume_slider" ).slider( "value" )  + "%");
  $( "#volume_slider" ).bind( "slidechange", function(event, ui) {
    myGroup.getCurrent().setVolume(ui.value);
  });
});
function doChangeVolume(currentSong)
{
  if(currentSong.isMuted())
    changeMuteUnmuteButton('unmute');
  else
    changeMuteUnmuteButton('mute');
  $("#volume").html(currentSong.getVolume()+"%");
}

function duUpdateDuration(currentSong)
{
  $( "#time_slider" ).slider( "option", "max", currentSong.getDuration() );
}

function doUpdateTime(currentSong)
{
  $("#timer").html(buzz.toTimer( currentSong.getTime() ));
  $( "#time_slider" ).slider( "option", "value", currentSong.getTime() );
}

function doMoveToNext(currentSong, group)
{
  doStop(currentSong);
  group.getNext();
  doPlayPause(currentSong);
  $( "#time_slider" ).slider( "option", "value", currentSong.getTime() );
}

function doMuteUnmute(currentSong)
{
  currentSong.toggleMute();
  if(currentSong.isMuted())
    $( "#volume_slider" ).slider( "disable");
  else
    $( "#volume_slider" ).slider( "enable");
}

function doPlayPause(currentSong)
{
  if(currentSong.isPaused())
    changePlayPauseButton('pause');
  else
    changePlayPauseButton('play');
  currentSong.togglePlay();
}

function doStop(currentSong)
{
  currentSong.stop();
  changePlayPauseButton('play');
}

function changePlayPauseButton(stateToGo)
{
  var button = $('#play_pause');
  if(stateToGo == "pause")
    var img = '/images/player/pause-48.png';
  else
    var img = '/images/player/play-48.png';
  button.attr('src', img);
}

function changeMuteUnmuteButton(stateToGo)
{
  var button = $('#mute_unmute');
  if(stateToGo == "mute")
    var img = '/images/player/mute.png';
  else
    var img = '/images/player/unmute.png';
  button.attr('src', img);
}
</script>