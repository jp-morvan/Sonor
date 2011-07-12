  <li>
    <img src="/images/icon/delete.png" alt="supprimer la playlist" class="delete" id="delete_playlist_<?php echo $playlist->slug ?>_<?php echo $playlist->id ?>" />
    <a href="#" onclick="show('playlists', '<?php echo $playlist->slug ?>')"><?php echo $playlist->titre ?></a> (<?php echo $count_chansons ?>)
  </li>