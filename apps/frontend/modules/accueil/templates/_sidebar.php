<?php if($sf_user->isAuthenticated()): ?>
<ul id="playlists_list">
  <div id="playlists">Playlists <img src="/images/icon/add.png" width="16" height="16" alt="ajouter une playlist" class="add" id="playlist" /></div>
<?php if(count($playlists) > 0): ?>
<?php foreach($playlists as $playlist): ?>
<?php include_partial('playlist_li', array('playlist' => $playlist, 'count_chansons' => $playlist->countChansons())) ?>
<?php endforeach; ?>
<?php endif; ?>
</ul>
<ul id="albums_list">
  <div id="albums">Albums</div>
<?php if(count($albums) > 0): ?>
<?php foreach($albums as $album): ?>
<?php include_partial('album_li', array('album' => $album, 'count_chansons' => $album->countChansons())) ?>
<?php endforeach; ?>
<?php endif; ?>
</ul>
<?php else: ?>
&nbsp;
<?php endif; ?>