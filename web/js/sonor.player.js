function sonorPlayer(buzzGroup)
{
  var volume_slider = $( "#sonor_player div.sound div.volume_slider" );
  var volume = $( "#sonor_player div.sound div.volume" );
  var time_slider = $( "#sonor_player div.player div.time_slider" );
  var timer = $( "#sonor_player div.player div.timer" );
  var play_pause = $( "#sonor_player div.controls div.buttons img.play_pause" );
  var mute_unmute = $( "#sonor_player div.controls div.buttons img.mute_unmute" );
  this.group = buzzGroup;
  this.sounds = buzzGroup.getSounds();
  this.currentSong = 0;
  
  this.getCurrentSong = function()
  {
    return this.sounds[this.currentSong];
  }
  
  this.changeSong = function(n)
  {
    var l = this.sounds.length;
    return this.sounds[Math.abs(this.currentSong = (this.currentSong + (n ? 1 : l - 1)) % l)];
  }
  
  this.getNextSong = function()
  {
    this.changeSong(1);
  }
  
  this.getPreviousSong = function()
  {
    this.changeSong(0);
  }
  
  this.doChangeVolume = function()
  {
    if(this.getCurrentSong().isMuted())
      this.changeMuteUnmuteButton('unmute');
    else
      this.changeMuteUnmuteButton('mute');
    volume.html(this.getCurrentSong().getVolume()+"%");
  }

  this.duUpdateDuration = function()
  {
    time_slider.slider( "option", "max", this.getCurrentSong().getDuration() );
  }

  this.doUpdateTime = function()
  {
    timer.html(buzz.toTimer( this.getCurrentSong().getTime() ));
    time_slider.slider( "option", "value", this.getCurrentSong().getTime() );
  }

  this.doMoveToNext = function()
  {
    this.doStop();
    this.getNextSong();
    this.doPlayPause();
    time_slider.slider( "option", "value", this.getCurrentSong().getTime() );
  }

  this.doMuteUnmute = function()
  {
    this.getCurrentSong().toggleMute();
    if(this.getCurrentSong().isMuted())
      volume_slider.slider( "disable");
    else
      volume_slider.slider( "enable");
  }

  this.doPlayPause = function()
  {
    this.getCurrentSong().togglePlay();
    if(this.getCurrentSong().isPaused())
      this.changePlayPauseButton('pause');
    else
      this.changePlayPauseButton('play');
  }

  this.doStop = function()
  {
    this.getCurrentSong().stop();
    this.changePlayPauseButton('play');
  }

  this.changePlayPauseButton = function(stateToGo)
  {
    if(stateToGo == "pause")
      var img = '/images/player/pause-48.png';
    else
      var img = '/images/player/play-48.png';
    play_pause.attr('src', img);
  }

  this.changeMuteUnmuteButton = function(stateToGo)
  {
    if(stateToGo == "mute")
      var img = '/images/player/mute.png';
    else
      var img = '/images/player/unmute.png';
    mute_unmute.attr('src', img);
  }
  
  // SLIDER DU VOLUME
  volume_slider.slider({
    range: "min",
    value: 80,
    min: 0,
    max: 100,
    step: 5,
    slide: function( event, ui ) {
      volume.html(ui.value + "%");
    }
  });
  volume.html( volume_slider.slider( "value" )  + "%");
  volume_slider.bind( "slidechange", function(event, ui) {
    getCurrentSong().setVolume(ui.value);
  });
  // SLIDER DU TEMPS
  /*time_slider.slider({
    range: "min",
    value: 0,
    min: 0,
    max: 0,
    step: 1,
    slide: function( event, ui ) {
      this.getCurrentSong().setTime(ui.value);
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
  });*/
}
