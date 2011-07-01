<?php

/**
 * Description of myWebRequest
 *
 * @author    Jean-Philippe MORVAN <jp.morvan@ville-villejuif.fr>
 * @version   26 mai 2010 10:45:59
 */
class myWebRequest extends browserDetectionWebRequest
{
  public function getServerName()
  {
    $pathArray = $this->getPathInfoArray();
    
    return isset($pathArray['SERVER_NAME']) ? $pathArray['SERVER_NAME'] : '';
  }

  public function getUrlWithoutServerAndScriptNames()
  {
    $tmp = explode($this->getServerName(), $this->getReferer());
    $ref = explode($this->getScriptName(), $tmp[count($tmp)-1]);
    return $ref[count($ref)-1];
  }
  
  public function getAudioFilePath() 
  {
    return '/uploads/audio/'.$this->getAudioFileType().'/';
  }
  
  public function getAudioFileType() 
  {
    if($this->getBrowserInformation() == 'Firefox')
    {
      return 'ogg';
    }
    return 'mp3';
  }
}
?>
