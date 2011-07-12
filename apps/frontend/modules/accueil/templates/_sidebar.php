<?php if($sf_user->isAuthenticated()): ?>
<ul id="playlists_list">
  <div id="playlists">Playlists <img src="/images/icon/add.png" width="16" height="16" alt="ajouter une playlist" class="add" id="add_playlist" /></div>
<?php if(count($playlists) > 0): ?>
<?php foreach($playlists as $playlist): ?>
<?php include_partial('playlist_li', array('playlist' => $playlist)) ?>
<?php endforeach; ?>
<?php endif; ?>
</ul>
<ul id="albums_list">
  <div id="albums">Albums <img src="/images/icon/add.png" width="16" height="16" alt="ajouter une playlist" class="add" id="add_album" /></div>
<?php if(count($albums) > 0): ?>
<?php foreach($albums as $album): ?>
<?php include_partial('album_li', array('album' => $album)) ?>
<?php endforeach; ?>
<?php endif; ?>
</ul>
<?php else: ?>
&nbsp;
<?php endif; ?>