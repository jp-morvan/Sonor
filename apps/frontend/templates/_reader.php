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
<script type="text/javascript">
ArrayAccess = function(data){
	this.data = data;
};
ArrayAccess.prototype = {
	current: 0,
	data: [],
	move: function(n){
		var l = this.data.length;
		return this.data[Math.abs(this.current = (this.current + (n ? 1 : l - 1)) % l)];
	},
	getNext: function(){
		return this.move(1);
	},
	getPrevious: function(){
		return this.move(0);
	},
	getCurrent: function(){
		return this.data[this.current];
	}
};
  
var sound1 = new buzz.sound("/uploads/audio/list/franz-ferdinand/franz-ferdinand/01-jacqueline.ogg");
var sound2 = new buzz.sound("/uploads/audio/list/franz-ferdinand/franz-ferdinand/02-tell-her-tonight.ogg");
var sound3 = new buzz.sound("/uploads/audio/list/franz-ferdinand/franz-ferdinand/03-take-me-out.ogg");
var liste = new ArrayAccess([sound1, sound2, sound3]);
var currentSound = sound1;

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
    currentSound.setVolume(ui.value);
  });
  // SLIDER DU TEMPS
  $( "#time_slider" ).slider({
    range: "min",
    value: 0,
    min: 0,
    max: 0,
    step: 1,
    slide: function( event, ui ) {
      currentSound.setTime(ui.value);
    }
  });
  // VOLUME CHANGE
  currentSound.bind("volumechange", function() {
    if(this.isMuted())
      changeMuteUnmuteButton('unmute');
    else
      changeMuteUnmuteButton('mute');
    $("#volume").html(this.getVolume()+"%");
  });
  // INIT DURACTION IN TIME SLIDER
  currentSound.bind("durationchange", function(e) {
    $( "#time_slider" ).slider( "option", "max", this.getDuration() );
  });
  // UPDATE SLIDER POSITION AND TIMER INDICATION
  currentSound.bind( "timeupdate", function() {
    $("#timer").html(buzz.toTimer( this.getTime() ));
    $( "#time_slider" ).slider( "option", "value", this.getTime() );
  });
  // STOP
  $('#next').live('click', function() {
    $('#stop').click();
    currentSound = liste.getNext();
    $('#play_pause').click();
    alert(currentSound.getTime());
    $( "#time_slider" ).slider( "option", "value", currentSound.getTime() );
  });
  // STOP
//  $('#stop').live('click', function() {
//    currentSound.stop();
//    changePlayPauseButton('play');
//  });
  // PLAY & PAUSE
  $('#play_pause').live('click', function() {
    if(currentSound.isPaused())
      changePlayPauseButton('pause');
    else
      changePlayPauseButton('play');
    currentSound.togglePlay();
  });
  // MUTE
  $('#mute_unmute').live('click', function() {
    currentSound.toggleMute();
    if(currentSound.isMuted())
      $( "#volume_slider" ).slider( "disable");
    else
      $( "#volume_slider" ).slider( "enable");
  });
});

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