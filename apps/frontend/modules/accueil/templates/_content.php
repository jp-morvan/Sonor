<ul>
<img src="/images/control_play_blue.png" alt="Jouer l'(a)<?php echo $type ?> <?php echo $titre ?>" onclick="play('<?php echo $type ?>', '<?php echo $slug ?>')" /> <?php echo $titre ?>
<?php foreach($chansons as $chanson): ?>
  <li><img src="/images/control_play_blue.png" alt="Jouer <?php echo $chanson['titre'] ?>" onclick="play('chanson', '<?php echo $chanson['slug'] ?>')" /> <?php echo $chanson['titre'] ?> -> <?php echo $chanson['duree'] ?></li>
<?php endforeach; ?>
</ul>