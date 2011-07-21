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
    currentSound.setVolume(ui.value);
  });
});
//ArrayAccess = function(data){
//	this.data = data;
//};
//ArrayAccess.prototype = {
//	current: 0,
//	data: [],
//	move: function(n){
//		var l = this.data.length;
//		return this.data[Math.abs(this.current = (this.current + (n ? 1 : l - 1)) % l)];
//	},
//	getNext: function(){
//		return this.move(1);
//	},
//	getPrevious: function(){
//		return this.move(0);
//	},
//	getCurrent: function(){
//		return this.data[this.current];
//	}
//};
  
//var sound1 = new buzz.sound("/uploads/audio/list/franz-ferdinand/franz-ferdinand/01-jacqueline", {formats: [ "ogg", "mp3"]});
//var sound2 = new buzz.sound("/uploads/audio/list/franz-ferdinand/franz-ferdinand/02-tell-her-tonight.ogg");
//var sound3 = new buzz.sound("/uploads/audio/list/franz-ferdinand/franz-ferdinand/03-take-me-out.ogg");
//var liste = new ArrayAccess([sound1, sound2, sound3]);
//var currentSound = sound1;
</script>