
  <li>
    <img src="/images/icon/delete.png" alt="supprimer l'album" class="delete" id="delete_album_<?php echo $album->slug ?>_<?php echo $album->id ?>" />
    <a href="#" onclick="show('album', '<?php echo $album->slug ?>')"><?php echo $album->titre ?></a> (<?php echo $count_chansons ?>)
  </li>