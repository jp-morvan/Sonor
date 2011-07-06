<ul><?php echo $slug ?>
<?php foreach($chansons as $chanson): ?>
  <li><img src="/images/control_play_blue.png" alt="Jouer <?php echo $chanson->titre ?>" onclick="play('chanson', '<?php echo $chanson->slug ?>')" /> <?php echo $chanson->titre ?> -> <?php echo $chanson->duree ?></li>
<?php endforeach; ?>
</ul>