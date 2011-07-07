<table id="chansons">
  <thead>
    <tr>
      <th>
        <img src="/images/control_play_blue.png" alt="Jouer <?php echo ($type == "album") ? "l'".$type: $type ?> '<?php echo $titre ?>'" onclick="play('<?php echo $type ?>', '<?php echo $slug ?>')" />
      </th>
      <th colspan="2">
        <?php echo $titre ?>
      </th>
    </tr>
  </thead>
  <tbody>
<?php foreach($chansons as $id => $chanson): ?>
    <tr class="<?php echo ($id%2 == 0) ? 'even' : 'odd' ?>">
      <td class="play">
        <img src="/images/control_play_blue.png" alt="Jouer la chanson '<?php echo $chanson['titre'] ?>'" onclick="play('chanson', '<?php echo $chanson['slug'] ?>')" />
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