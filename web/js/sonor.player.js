function sonorPlayer(buzzGroup, songs)
{
  this.volume_slider = $( "#sonor_player div.sound div.volume_slider" );
  this.volume = $( "#sonor_player div.sound div.volume" );
  this.time_slider = $( "#sonor_player div.player div.time_slider" );
  this.timer = $( "#sonor_player div.player div.timer" );
  this.artist = $( "#sonor_player div.player div.artist" );
  this.title = $( "#sonor_player div.player div.title" );
  this.play_pause = $( "#sonor_player img.play_pause" );
  this.mute_unmute = $( "#sonor_player img.mute_unmute" );
  this.previous = $( "#sonor_player img.previous" );
  this.next = $( "#sonor_player img.next" );
  this.stop = $( "#sonor_player img.stop" );
  this.group = buzzGroup;
  this.songs = songs != undefined ? songs : null;
  this.sounds = buzzGroup.getSounds();
  this.currentSong = 0;
  
  this.getCurrentSound = function()
  {
    return this.sounds[this.currentSong];
  }
  
  this.getRemainingTime = function()
  {
    return (this.getCurrentSound().getDuration() - this.getCurrentSound().getTime());
  }
  
  this.isEnding = function()
  {
    return (this.getRemainingTime() <= 3);
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
    this.volume.html(this.getCurrentSound().getVolume()+"%");
    return this;
  }
  
  this.updateTitle = function()
  {
    if(this.songs != null)
    {
      this.title.html(this.songs[this.currentSong]['title']);
    }
    return this;
  }
  
  this.updateArtist = function()
  {
    if(this.songs != null)
    {
      this.artist.html(this.songs[this.currentSong]['artist']);
    }
    return this;
  }

  this.duUpdateDuration = function()
  {
    this.time_slider.slider( "option", "max", this.getCurrentSound().getDuration() );
    return this;
  }

  this.doUpdateTime = function()
  {
    this.timer.html(buzz.toTimer( this.getCurrentSound().getTime() ));
    this.time_slider.slider( "option", "value", this.getCurrentSound().getTime() );
    return this;
  }

  this.doMoveToNext = function()
  {
    this.doStop().getNextSong().doPlay();
    this.time_slider.slider( "option", "value", this.getCurrentSound().getTime() );
    return this;
  }

  this.doMoveToPrevious = function()
  {
    this.doStop().getPreviousSong().doPlay();
    this.time_slider.slider( "option", "value", this.getCurrentSound().getTime() );
    return this;
  }

  this.doMuteUnmute = function()
  {
    this.getCurrentSound().toggleMute();
    if(this.getCurrentSound().isMuted())
    {
      this.changeMuteUnmuteButton('unmute');
      this.volume_slider.slider( "disable");
    }
    else
    {
      this.changeMuteUnmuteButton('mute');
      this.volume_slider.slider( "enable");
    }
    return this;
  }

  this.doPlay = function()
  {
    this.updateTitle()
        .updateArtist()
        .duUpdateDuration()
        .getCurrentSound()
        .play();
    this.changePlayPauseButton('pause');
    return this;
  }

  this.doPlayPause = function()
  {
    this.getCurrentSound().togglePlay();
    if(this.getCurrentSound().isPaused())
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
    if(!this.getCurrentSound().isEnded() && this.getCurrentSound().getTime() > 0)
    {
      this.getCurrentSound().pause();
      this.getCurrentSound().setTime( 0 );
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
    player.getCurrentSound().setVolume(ui.value);
  });
  // SLIDER DU TEMPS
  player.time_slider.slider({
    range: "min",
    value: 0,
    min: 0,
    max: 0,
    step: 1,
    slide: function( event, ui ) {
      player.getCurrentSound().setTime(ui.value);
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
  player.group.bind("ended", function(event) {
    player.doMoveToNext()
  });
  // UPDATE SLIDER POSITION AND TIMER INDICATION
  player.group.bind( "timeupdate", function(event) {
    player.doUpdateTime();
    });
  // NEXT
  player.next.live('click', function(event) {
    player.doMoveToNext();
  });
  // PREVIOUS
  player.previous.live('click', function(event) {
    player.doMoveToPrevious();
  });
  // STOP
  player.stop.live('click', function(event) {
    player.doStop();
  });
  // PLAY & PAUSE
  player.play_pause.live('click', function(event) {
    player.doPlayPause();
  });
  // MUTE
  player.mute_unmute.live('click', function(event) {
    player.doMuteUnmute();
  });
}
