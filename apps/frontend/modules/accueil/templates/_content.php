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
        <img src="/images/play.png" class="play" alt="Jouer la chanson '<?php echo $chanson['titre'] ?>'" onclick="play('chanson', '<?php echo $chanson['slug'] ?>')" />
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