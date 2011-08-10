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
  public static function stylesheet_tag_with_css_crush() 
  {
    $sources = func_get_args();
    $sourceOptions = (func_num_args() > 1 && is_array($sources[func_num_args() - 1])) ? array_pop($sources) : array();

    $html = '';
    foreach ($sources as $source)
    {
      $absolute = false;
      if (isset($sourceOptions['absolute']))
      {
        unset($sourceOptions['absolute']);
        $absolute = true;
      }

      $condition = null;
      if (isset($sourceOptions['condition']))
      {
        $condition = $sourceOptions['condition'];
        unset($sourceOptions['condition']);
      }

      if (!isset($sourceOptions['raw_name']))
      {
        $source = stylesheet_path($source, $absolute);
      }
      else
      {
        unset($sourceOptions['raw_name']);
      }
//      $source = CssCrush::file($source, array('versioning'  => false));
echo $source;
      $options = array_merge(array('rel' => 'stylesheet', 'type' => 'text/css', 'media' => 'screen', 'href' => $source), $sourceOptions);
      $tag = tag('link', $options);

      if (null !== $condition)
      {
        $tag = comment_as_conditional($condition, $tag);
      }

      $html .= $tag."\n";
    }

    return $html;
  }
  
  public static function include_stylesheets_with_css_crush($response) 
  {
    sfConfig::set('symfony.asset.stylesheets_included', true);

    $html = '';
    foreach ($response->getStylesheets() as $file => $options)
    {
      $html .= self::stylesheet_tag_with_css_crush($file, $options);
    }

    return $html;
  }
  
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
  
  public static function getFilenameWithoutExtension($file, $lower = true)
  {
    $filename = self::getFilename($file, $lower);
    $file_len = strlen($filename);
    $ext_len = strlen(self::getExtension($file));
    return substr($filename, 0, ($file_len - $ext_len - 1));
  }
  
  public static function getFilename($file, $lower = true)
  {
    $filename = basename($file);
    if($lower === true)
    {
      $filename = strtolower($filename);
    }
    return $filename;
  }
  
  public static function getSlugifyFilename($file) 
  {
    return tools::slugify(self::getFilenameWithoutExtension($file)).".".self::getExtension($file);
  }
  
  public static function moveFileToDir($dir, $file, $new_name = null)
  {
    if(!file_exists($file))
    {
//      throw new sfException('Le fichier '.$file.' n\'existe pas.');
      return 'Le fichier '.$file.' n\'existe pas.';
    }
    if(!is_dir($dir))
    {
//      throw new sfException('Le répertoire '.$dir.' n\'existe pas.');
      return 'Le répertoire '.$dir.' n\'existe pas.';
    }
    if(!is_writable($dir))
    {
//      throw new sfException('Le répertoire '.$dir.' n\'est pas accessible en écriture.');
      return 'Le répertoire '.$dir.' n\'est pas accessible en écriture.';
    }
    if(is_null($new_name))
    {
      $new_name = tools::getFilename($file);
    }
    $new_file = $dir.$new_name;
    exec('mv "'.$file.'" "'.$new_file.'"', $output);
    return true;
  }
  
  public static function mkdir($path) 
  {
    if(!is_dir($path))
    {
      $current_umask = umask(0000);
      mkdir($path, 0777, true);
      umask($current_umask);
    }
  }
  
  public static function scanTree($dir, $ext = null) 
  {
    $path = '';
    $stack[] = $dir;
    while ($stack) 
    {
     $thisdir = array_pop($stack);
     if ($dircont = scandir($thisdir)) 
     {
       $i=0;
       while (isset($dircont[$i])) 
       {  
         if ($dircont[$i] !== '.' && $dircont[$i] !== '..') 
         {
           $current_file = "{$thisdir}/{$dircont[$i]}";
           if (is_file($current_file)) 
           {
             $current_ext = self::getExtension($current_file);
             if((!is_null($ext) && in_array($current_ext, $ext)) || is_null($ext))
             {
               $path[] = $current_file;
             }
           } 
           elseif (is_dir($current_file)) 
           {
             $stack[] = $current_file;
           }
         }
         $i++;
       }
     }
    }
    return $path;
  }
}
?>
