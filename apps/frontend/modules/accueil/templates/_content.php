<div>
  <div class="bouton">
    <img src="/images/big_play.png" class="play" alt="Jouer <?php echo ($type == "album") ? "l'".$type: $type ?> '<?php echo $relation['titre'] ?>'" onclick="lecture('album')" />Ecouter l'album
  </div>
<?php if($type == "album"): ?>
  <div id="album_<?php echo $relation->slug ?>_<?php echo $relation->id ?>"  class="bouton <?php echo ($in_list) ? 'remove' : 'add' ?>">
    <?php echo ($in_list)? 'Supprimer de ma musique': 'Ajouter à ma musique' ?>
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
        <img src="/images/play.png" class="play" alt="Jouer la chanson '<?php echo $chanson['titre'] ?>'" onclick="lecture('chanson', '<?php echo $id ?>')" />
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
  var myGroup = new buzz.group([ 
<?php foreach($list as $l): ?>
    <?php echo 'new buzz.sound(\''.$l.'\', {formats: [ "ogg", "mp3"]}),'; ?>
<?php endforeach; ?>
]);
//  var myGroup = new buzz.sound('/uploads/audio/list/empty', {formats: [ "ogg", "mp3"]});;
  function lecture(type, piste)
  {
    /*if(type == "chanson")
    {
      myGroup.stop();
      myGroup = new buzz.sound(''+pistes[piste]+'', {formats: [ "ogg", "mp3"]});
      $('#play_pause').click();
    }*/
    if(type == "album")
    {
      myGroup.getCurrent().play();
    }
  }
  var player = new sonorPlayer(myGroup);
  player.changePlayPauseButton('pause');
//  player.changePlayPauseButton('pause');
/*$(function() {
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
    myGroup.setVolume(ui.value);
  });
  // SLIDER DU TEMPS
  $( "#time_slider" ).slider({
    range: "min",
    value: 0,
    min: 0,
    max: 0,
    step: 1,
    slide: function( event, ui ) {
      myGroup.getCurrent().setTime(ui.value);
    }
  });
  // VOLUME CHANGE
  myGroup.bind("volumechange", function() {
    doChangeVolume(myGroup.getCurrent());
  });
  // INIT DURACTION IN TIME SLIDER
  myGroup.bind("durationchange", function(e) {
    duUpdateDuration(myGroup.getCurrent());
  });
  // UPDATE SLIDER POSITION AND TIMER INDICATION
  myGroup.bind( "timeupdate", function() {
    doUpdateTime(myGroup.getCurrent());
  });
  // STOP
  $('#next').live('click', function() {
    doMoveToNext(myGroup.getCurrent(), myGroup);
  });
  // STOP
  $('#stop').live('click', function() {
    doStop(myGroup.getCurrent());
  });
  // PLAY & PAUSE
  $('#play_pause').live('click', function() {
    doPlayPause(myGroup.getCurrent());
  });
  // MUTE
  $('#mute_unmute').live('click', function() {
    doMuteUnmute(myGroup.getCurrent());
  });
});
*/
</script>