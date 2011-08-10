function sonorPlayer(buzzGroup)
{
  this.volume_slider = $( "#sonor_player div.sound div.volume_slider" );
  this.volume = $( "#sonor_player div.sound div.volume" );
  this.time_slider = $( "#sonor_player div.player div.time_slider" );
  this.timer = $( "#sonor_player div.player div.timer" );
  this.play_pause = $( "#sonor_player div.controls div.buttons img.play_pause" );
  this.mute_unmute = $( "#sonor_player div.controls div.buttons img.mute_unmute" );
  this.group = buzzGroup;
  this.currentSong = this.group.getCurrent();
  
  this.doChangeVolume = function()
  {
    if(this.currentSong.isMuted())
      this.changeMuteUnmuteButton('unmute');
    else
      this.changeMuteUnmuteButton('mute');
    this.volume.html(this.currentSong.getVolume()+"%");
  }

  this.duUpdateDuration = function()
  {
    this.time_slider.slider( "option", "max", this.currentSong.getDuration() );
  }

  this.doUpdateTime = function()
  {
    this.timer.html(buzz.toTimer( this.currentSong.getTime() ));
    this.time_slider.slider( "option", "value", this.currentSong.getTime() );
  }

  this.doMoveToNext = function()
  {
    this.doStop();
    this.currentSong = this.group.getNext();
    this.doPlayPause();
    this.time_slider.slider( "option", "value", this.currentSong.getTime() );
  }

  this.doMuteUnmute = function()
  {
    this.currentSong.toggleMute();
    if(this.currentSong.isMuted())
      this.volume_slider.slider( "disable");
    else
      this.volume_slider.slider( "enable");
  }

  this.doPlayPause = function()
  {
    this.currentSong.togglePlay();
    if(this.currentSong.isPaused())
      this.changePlayPauseButton('pause');
    else
      this.changePlayPauseButton('play');
  }

  this.doStop = function()
  {
    this.currentSong.stop();
    this.changePlayPauseButton('play');
  }

  this.changePlayPauseButton = function(stateToGo)
  {
    if(stateToGo == "pause")
      var img = '/images/player/pause-48.png';
    else
      var img = '/images/player/play-48.png';
    this.play_pause.attr('src', img);
  }

  this.changeMuteUnmuteButton = function(stateToGo)
  {
    if(stateToGo == "mute")
      var img = '/images/player/mute.png';
    else
      var img = '/images/player/unmute.png';
    this.mute_unmute.attr('src', img);
  }
  
  // SLIDER DU VOLUME
  this.volume_slider.slider({
    range: "min",
    value: 80,
    min: 0,
    max: 100,
    step: 5,
    slide: function( event, ui ) {
      this.volume.html(ui.value + "%");
    }
  });
  this.volume.html( this.volume_slider.slider( "value" )  + "%");
  this.volume_slider.bind( "slidechange", function(event, ui) {
    this.currentSong.setVolume(ui.value);
  });
  // SLIDER DU TEMPS
  this.time_slider.slider({
    range: "min",
    value: 0,
    min: 0,
    max: 0,
    step: 1,
    slide: function( event, ui ) {
      this.currentSong.setTime(ui.value);
    }
  });
  // VOLUME CHANGE
  this.group.bind("volumechange", function(event) {
    event.doChangeVolume();
  });
  // INIT DURACTION IN TIME SLIDER
  this.group.bind("durationchange", function(event) {
    event.duUpdateDuration();
  });
  // UPDATE SLIDER POSITION AND TIMER INDICATION
  this.group.bind( "timeupdate", function(event) {
    event.doUpdateTime();
  });
  // STOP
  $('#next').live('click', function(event) {
    event.doMoveToNext();
  });
  // STOP
  $('#stop').live('click', function(event) {
    event.doStop();
  });
  // PLAY & PAUSE
  $('#play_pause').live('click', function(event) {
    event.doPlayPause();
  });
  // MUTE
  $('#mute_unmute').live('click', function(event) {
    event.doMuteUnmute();
  });
}
