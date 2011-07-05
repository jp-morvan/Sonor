<?php

/**
 * Description of audio
 *
 * @author JP-MORVAN
 */
class audio extends getID3
{
  private $_infos = null,
          $_tags_type = array('id3v2', 'id3v1', 'lyrics3', 'ape'),
          $_id3v2_tags = array(),
          $_id3v1_tags = array(),
          $_lyrics3_tags = array(),
          $_ape_tags = array(),
          $_id3v2_fields = array('title', 'artist', 'album', 'track_number'),
          $_id3v1_fields = array('title', 'artist', 'album', 'track'),
          $_lyrics3_fields = array('title', 'artist', 'album', 'track'),
          $_ape_fields = array('title', 'artist', 'album', 'track'),
          $_tags = array();
  
  
  public function __construct($filename)
  {
    $this->encoding = "UTF-8";
    $this->_infos = parent::analyze($filename);
    if($this->hasTags())
    {
      $this->setTags();
    }
  }

  
  public function hasTags()
  {
    return isset($this->_infos['tags']);
  }
  
  public function setTags()
  {
    foreach($this->_tags_type as $tag_type)
    {
      if(isset($this->_infos['tags'][$tag_type]))
      {
        $this->{'_'.$tag_type.'_tags'} = $this->_infos['tags'][$tag_type];
        $this->_parseTags($tag_type);
      }
    }
    $this->_mergeTags();
  }
  
  private function _parseTags($tag_type)
  {
    $tags = $this->{'_'.$tag_type.'_tags'};
    $tmp = array();
    foreach($this->{'_'.$tag_type.'_fields'} as $field)
    {
      if(isset($tags[$field]))
      {
        $tmp[($field == "track_number") ? 'track': $field] = $tags[$field][0];
      }
    }
    $this->{'_'.$tag_type.'_tags'} = $tmp;
  }
  
  private function _mergeTags()
  {
    foreach($this->_tags_type as $tag_type)
    {
      $count = count($this->{'_'.$tag_type.'_tags'});
      if($count == 4)
      {
        $this->_tags = $this->{'_'.$tag_type.'_tags'};
      }
    }
  }
    
  public function getDuration() 
  {
    return date('H:i:s', mktime(0, 0, $this->_infos['playtime_seconds'], 0, 0, 0));
  }
  
  public function getTags()
  {
    return $this->_tags;
  }
  
  public function getFilename()
  {
    return $this->_infos['filename'];
  }
  
  public function getInfos()
  {
    return $this->_infos;
  }
  
  public function getTag($tag)
  {
    if(isset($this->_tags[$tag]))
    {
      return $this->_tags[$tag];
    }
    return null;
  }
}

?>
