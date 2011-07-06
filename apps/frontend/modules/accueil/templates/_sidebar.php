<?php if($sf_user->isAuthenticated()): ?>
<ul>
<?php if(count($playlists) > 0): ?>
  <span>Playlists</span>
<?php foreach($playlists as $playlist): ?>
  <li><a href="#" onclick="show('playlist', '<?php echo $playlist->slug ?>')"><?php echo $playlist->titre ?></a></li>
<?php endforeach; ?>
<?php endif; ?>
  <span>Albums</span>
<?php foreach($albums as $album): ?>
  <li><a href="#" onclick="show('album', '<?php echo $album->slug ?>')"><?php echo $album->titre ?></a></li>
<?php endforeach; ?>
</ul>
<?php else: ?>
&nbsp;
<?php endif; ?>