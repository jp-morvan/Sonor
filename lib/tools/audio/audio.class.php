<?php

/**
 * Description of audio
 *
 * @author JP-MORVAN
 */
class audio extends getID3
{
  private $_infos = null,
          $_tags = null;
  
  function analyze($filename) 
  {
    $this->_infos = parent::analyze($filename);
    $this->_tags = $this->_infos['tags']['id3v1'];
    return $this->_infos;
  }
  
  public function getDuration() 
  {
    return date('H:i:s', mktime(0, 0, $this->_infos['playtime_seconds'], 0, 0, 0));
  }
  
  public function getArtiste() 
  {
    return $this->_tags['artist'][0];
  }
  
  public function getAlbum() 
  {
    return $this->_tags['album'][0];
  }
  
  public function getTitre() 
  {
    return $this->_tags['title'][0];
  }
}

?>
