<div>
  <img src="/images/big_play.png" class="play" alt="Jouer <?php echo ($type == "album") ? "l'".$type: $type ?> '<?php echo $relation['titre'] ?>'" onclick="play('<?php echo $type ?>', '<?php echo $relation['slug'] ?>')" /><br />
<?php if($type == "album"): ?>
  <div id="album_in_list">
<?php include_partial('album_add_remove', array('relation' => $relation, 'in_list' => $in_list)) ?>
  </div>
<?php endif; ?>
</div>
<table id="chansons">
  <thead>
    <tr>
      <th colspan="3">
        <?php echo $relation['titre'] ?>
      </th>
    </tr>
  </thead>
  <tbody>
<?php foreach($chansons as $id => $chanson): ?>
    <tr class="<?php echo ($id%2 == 0) ? 'even' : 'odd' ?>">
      <td class="play">
        <img src="/images/play.png" class="play" alt="Jouer la chanson '<?php echo $chanson['titre'] ?>'" onclick="lecture('<?php echo $id ?>', 'chanson')" />
<!--        <img src="/images/play.png" class="play" alt="Jouer la chanson '<?php echo $chanson['titre'] ?>'" onclick="play('chanson', '<?php echo $chanson['slug'] ?>')" />-->
      </td>
      <td class="titre">
        <?php echo $chanson['titre'] ?>
      </td>
      <td class="duree">
        <?php echo Chanson::writeDuree($chanson['duree']) ?>
      </td>
    </tr>
<?php endforeach; ?>
  </tbody>
</table>
<script type="text/javascript">
  var currentSound = new buzz.sound('/uploads/audio/list/empty', {formats: [ "ogg", "mp3"]});;
  var pistes = [
<?php foreach($list as $l): ?>
    "<?php echo $l ?>",
<?php endforeach; ?>
  ];
  function lecture(piste, type)
  {
    if(type == "chanson")
    {
      currentSound.stop();
      currentSound = new buzz.sound(''+pistes[piste]+'', {formats: [ "ogg", "mp3"]});
      $('#play_pause').click();
    }
  }

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