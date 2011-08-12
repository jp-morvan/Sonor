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
<?php $i = 0 ?>
<?php foreach($chansons as $id => $chanson): ?>
    <tr class="<?php echo ($id%2 == 0) ? 'even' : 'odd' ?>">
      <td class="play">
        <img src="/images/play.png" class="play" alt="Jouer la chanson '<?php echo $chanson['titre'] ?>'" onclick="lecture('chanson', '<?php echo $i++ ?>')" />
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
<?php foreach($files as $file): ?>
    <?php echo 'new buzz.sound(\''.$file.'\', {formats: [ "ogg", "mp3"]}),'; ?>
<?php endforeach; ?>
]);

  var songs = {<?php echo $sf_data->getRaw('files_data') ?>};
  player = new sonorPlayer(myGroup, songs);
  bindPlayerEvents(player);
  function lecture(type, piste)
  {
    if(type == "album")
    {
      piste = 0;
    }
    player.doStopAndPlay(piste);
  }
</script>