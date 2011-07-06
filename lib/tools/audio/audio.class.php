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
          $_id3v2_fields = array('title', 'artist', 'album', 'track_number', 'band'),
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
  
  public function hasTypeOfTag($type)
  {
    if($this->hasTags())
    {
      return array_key_exists($type, $this->getTags());
    }
    return false;
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
    // ID3V2
    if($tag_type == 'id3v2')
    {
      if(isset($tags['title']))
      {
        $tmp['title'] = $this->_getFieldValue('id3v2', 'title');
      }
      if(isset($tags['artist']) || isset($tags['band']))
      {
        $tmp['artist'] = (isset($tags['artist']) ? $this->_getFieldValue('id3v2', 'artist'): $this->_getFieldValue('id3v2', 'band'));
      }
      if(isset($tags['album']))
      {
        $tmp['album'] = $this->_getFieldValue('id3v2', 'album');
      }
      if(isset($tags['track_number']))
      {
        $tmp['track'] = $this->_getFieldValue('id3v2', 'track_number');
      }
    }
    // ID3V1
    if($tag_type == 'id3v1')
    {
      if(isset($tags['title']))
      {
        $tmp['title'] = $this->_getFieldValue('id3v1', 'title');
      }
      if(isset($tags['artist']))
      {
        $tmp['artist'] = $this->_getFieldValue('id3v1', 'artist');
      }
      if(isset($tags['album']))
      {
        $tmp['album'] = $this->_getFieldValue('id3v1', 'album');
      }
      if(isset($tags['track']))
      {
        $tmp['track'] = $this->_getFieldValue('id3v1', 'track');
      }
    }
    // LYRICS3
    if($tag_type == 'lyrics3')
    {
    }
    // APE
    if($tag_type == 'ape')
    {
    }
    $this->{'_'.$tag_type.'_tags'} = $tmp;
  }
  
  private function _mergeTags()
  {
    $this->_tags = array_merge($this->_ape_tags, $this->_lyrics3_tags, $this->_id3v1_tags, $this->_id3v2_tags);
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
  
  public function hasTag($tag) 
  {
    return isset($this->_tags[$tag]);
  }
  
  public function getTag($tag)
  {
    return $this->_tags[$tag];
  }
  
  public function hasEnoughTags() 
  {
    return ($this->hasTag('title') && $this->hasTag('artist') && $this->hasTag('album'));
  }
  
  private function _getFieldValue($tag_type, $field)
  {
    $tag = $this->{'_'.$tag_type.'_tags'};
    return $tag[$field][0];
  }
}

?>
