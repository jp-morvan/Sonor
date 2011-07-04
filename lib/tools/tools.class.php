<?php

/*
 * This file has been created the 3 févr. 2010 at 15:08:51
 */

/**
 * Description of toolsclass
 *
 * @author    Jean-Philippe MORVAN <jp.morvan@ville-villejuif.fr>
 */
class tools
{
  public static $required_actions = array(
      'edit',
      'update',
      'new',
      'create'
  );

  public static function userProxy()
  {
    return sfContext::getInstance()->getUser();
  }

  public static function guardUserProxy()
  {
    return self::userProxy()->getGuardUser();
  }

  public static function hasContext()
  {
    try
    {
      sfContext::getInstance();
      return true;
    }
    catch(Exception $e)
    {
      return false;
    }
  }

  public static function pr($tab, $label = null)
  {
    $firephp = sfFirePHP::getInstance(true);
    $options = array('maxObjectDepth' => 2,
                 'maxArrayDepth' => 20,
                 'useNativeJsonEncode' => true,
                 'includeLineNumbers' => true);
    $firephp->setOptions($options);
    $firephp->info($tab, $label);
  }

  public static function removeCharactersAndLowercase($string)
  {
    $string = htmlentities($string, ENT_NOQUOTES, 'utf-8');
    $string = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml)\;#', '\1', $string);
    $string = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $string);
    $string = preg_replace('#\&[^;]+\;#', '', $string);
    $string = preg_replace("/[^a-zA-Z0-9\s]/", ' ', $string);
    $string = trim($string);
    $tmp = array();
    foreach(explode(' ', $string) as $s)
    {
      if($s != "") $tmp[] = $s;
    }
    $string = join('-', $tmp);
    return strtolower($string);
  }

  public static function slugify($text, $replace = "-")
  {
    $text = preg_replace('/\W+/', $replace, $text);
    return strtolower(trim($text, $replace));
  }

  public static function parsePercent($string, $pdf)
  {
    $exp = '/%{2}(?<var>\w+)%{2}/';
    if(preg_match_all($exp, $string, $matches))
    {
      foreach($matches['var'] as $id => $var)
      {
        $tmp = $pdf->{$var};
        if(!is_null($tmp))
        {
          $string = preg_replace('/'.$matches[0][$id].'/', $tmp, $string);
        }
      }
    }
    return $string;
  }
  
  public static function getExtension($file)
  {
    return substr(strrchr(self::getFilename($file), "."), 1);
  }
  
  public static function getFilenameWithoutExtension($file)
  {
    $filename = self::getFilename($file);
    $file_len = strlen($filename);
    $ext_len = strlen(self::getExtension($file));
    return substr($filename, 0, ($file_len - $ext_len - 1));
  }
  
  public static function getFilename($file)
  {
    return strtolower(basename($file));
  }
  
  public static function moveFilesToDir($dir, $files)
  {
    if(!is_array($files))
    {
      $files = array($files);
    }
    foreach($files as $file)
    {
      if(!file_exists($file))
      {
        throw new sfException('Le fichier '.$file.' n\'existe pas.');
      }
      if(!is_dir($dir))
      {
        throw new sfException('Le répertoire '.$dir.' n\'existe pas.');
      }
      if(!is_writable($dir))
      {
        throw new sfException('Le répertoire '.$dir.' n\'est pas accessible en écriture.');
      }
      exec('mv '.$file.' '.$dir, $output);
      return $output;
    }
  }
}
?>
