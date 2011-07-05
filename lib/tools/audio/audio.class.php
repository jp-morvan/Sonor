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
    for($i=1; $i < 10; $i++)
    {
      if(isset($this->_infos['tags']['id3v'.$i]))
      {
        $this->_tags = $this->_infos['tags']['id3v'.$i];
        return;
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
      return $this->_tags[$tag][0];
    }
    return null;
  }
}

?>
