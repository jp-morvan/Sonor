<?php

/**
 * Description of convertPath
 *
 * @author jp
 */
class convertDir extends convert
{
  private $_dir;
  
  public function __construct($dir)
  {
    $this->_dir = $dir;
  }
  
  public function convertDir()
  {
    foreach(scandir($this->_dir) as $file)
    {
      $path = $this->_dir.$file;
      if(!is_dir($path))
      {
        tools::pr($this->convert($path));
        $this->moveToRightDir($path);
      }
    }
  }
  
  private function moveToRightDir($path)
  {
    
  }
}

?>
