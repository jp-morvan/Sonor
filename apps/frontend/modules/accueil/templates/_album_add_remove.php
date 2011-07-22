<?php if($in_list === false): ?>
  <img src="/images/icon/favoris-add.png" class="add" id="add_album_<?php echo $relation['slug'] ?>" alt="Ajouter l'album '<?php echo $relation['titre'] ?>' à ma musique" /> Ajouter à ma musique
<?php else: ?>
  <img src="/images/icon/favoris-remove.png" class="delete" id="delete_album_<?php echo $relation['slug'] ?>_<?php echo $relation['id'] ?>_icon" alt="Supprimer l'album '<?php echo $relation['titre'] ?>' de ma musique" /> Supprimer de ma musique
<?php endif; ?>