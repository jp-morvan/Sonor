<?php if($sf_user->isAuthenticated()): ?>
<ul>
  <span>Playlists</span>
<?php foreach($playlists as $playlist): ?>
  <li><a href="#" onclick="show('playlist', '<?php echo $playlist->slug ?>')"><?php echo $playlist->titre ?></a></li>
<?php endforeach; ?>
  <span>Albums</span>
<?php foreach($albums as $album): ?>
  <li><a href="#" onclick="show('album', '<?php echo $album->slug ?>')"><?php echo $album->titre ?></a></li>
<?php endforeach; ?>
</ul>
<?php else: ?>
&nbsp;
<?php endif; ?>