function sonorPlayer(buzzGroup)
{
  this.volume_slider = $( "#sonor_player div.sound div.volume_slider" );
  this.volume = $( "#sonor_player div.sound div.volume" );
  this.time_slider = $( "#sonor_player div.player div.time_slider" );
  this.timer = $( "#sonor_player div.player div.timer" );
  this.play_pause = $( "#sonor_player div.controls div.buttons img.play_pause" );
  this.mute_unmute = $( "#sonor_player div.controls div.buttons img.mute_unmute" );
  this.group = buzzGroup;
  this.sounds = buzzGroup.getSounds();
  this.currentSong = 0;
  
  this.getCurrentSong = function()
  {
    return this.sounds[this.currentSong];
  }
  
  this.moveSong = function(n)
  {
    var l = this.sounds.length;
    return this.sounds[Math.abs(this.currentSong = (this.currentSong + (n ? 1 : l - 1)) % l)];
  }
  
  this.listenSong = function(n)
  {
    this.currentSong = n;
    return this;
  }
  
  this.getNextSong = function()
  {
    this.moveSong(1);
    return this;
  }
  
  this.getPreviousSong = function()
  {
    this.moveSong(0);
    return this;
  }
  
  this.doChangeVolume = function()
  {
    if(this.getCurrentSong().isMuted())
      this.changeMuteUnmuteButton('unmute');
    else
      this.changeMuteUnmuteButton('mute');
    this.volume.html(this.getCurrentSong().getVolume()+"%");
    return this;
  }

  this.duUpdateDuration = function()
  {
    this.time_slider.slider( "option", "max", this.getCurrentSong().getDuration() );
    return this;
  }

  this.doUpdateTime = function()
  {
    this.timer.html(buzz.toTimer( this.getCurrentSong().getTime() ));
    this.time_slider.slider( "option", "value", this.getCurrentSong().getTime() );
    return this;
  }

  this.doMoveToNext = function()
  {
    this.doStop().getNextSong().doPlay();
    this.time_slider.slider( "option", "value", this.getCurrentSong().getTime() );
    return this;
  }

  this.doMoveToPrevious = function()
  {
    this.doStop().getPreviousSong().doPlay();
    this.time_slider.slider( "option", "value", this.getCurrentSong().getTime() );
    return this;
  }

  this.doMuteUnmute = function()
  {
    this.getCurrentSong().toggleMute();
    if(this.getCurrentSong().isMuted())
      this.volume_slider.slider( "disable");
    else
      this.volume_slider.slider( "enable");
    return this;
  }

  this.doPlay = function()
  {
    this.getCurrentSong().play();
    this.changePlayPauseButton('pause');
    return this;
  }

  this.doPlayPause = function()
  {
    this.getCurrentSong().togglePlay();
    if(this.getCurrentSong().isPaused())
      this.changePlayPauseButton('play');
    else
      this.changePlayPauseButton('pause');
    return this;
  }

  this.doStopAndPlay = function(n)
  {
    return this.doStop().listenSong(n).doPlay();
  }

  this.doStop = function()
  {
    if(this.getCurrentSong().getTime() > 0)
    {
      this.getCurrentSong().pause();
      this.getCurrentSong().setTime( 0 );
      this.changePlayPauseButton('play');
    }
    return this;
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
}

function bindPlayerEvents(player)
{
  // SLIDER DU VOLUME
  player.volume_slider.slider({
    range: "min",
    value: 80,
    min: 0,
    max: 100,
    step: 5,
    slide: function( event, ui ) {
      player.volume.html(ui.value + "%");
    }
  });
  player.volume.html( player.volume_slider.slider( "value" )  + "%");
  player.volume_slider.bind( "slidechange", function(event, ui) {
    player.getCurrentSong().setVolume(ui.value);
  });
  // SLIDER DU TEMPS
  player.time_slider.slider({
    range: "min",
    value: 0,
    min: 0,
    max: 0,
    step: 1,
    slide: function( event, ui ) {
      player.getCurrentSong().setTime(ui.value);
    }
  });
  // VOLUME CHANGE
  player.group.bind("volumechange", function(event) {
    player.doChangeVolume();
  });
  // INIT DURATION IN TIME SLIDER
  player.group.bind("durationchange", function(event) {
    player.duUpdateDuration();
  });
  // UPDATE SLIDER POSITION AND TIMER INDICATION
  player.group.bind( "timeupdate", function(event) {
    player.doUpdateTime();
    });
  // NEXT
  $('#sonor_player img.next').live('click', function(event) {
    player.doMoveToNext();
  });
  // PREVIOUS
  $('#sonor_player img.previous').live('click', function(event) {
    player.doMoveToPrevious();
  });
  // STOP
  $('#sonor_player img.stop').live('click', function(event) {
    player.doStop();
  });
  // PLAY & PAUSE
  $('#sonor_player img.play_pause').live('click', function(event) {
    player.doPlayPause();
  });
  // MUTE
  $("#sonor_player img.mute_unmute").live('click', function(event) {
    player.doMuteUnmute();
  });
}
