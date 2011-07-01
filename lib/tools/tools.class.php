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

  public static function clearMenuCache()
  {
    if(self::hasContext())
    {
      if ($cacheManager = sfContext::getInstance()->getViewCacheManager())
      {
        $cacheManager->remove('@sf_cache_partial?module=menu&action=_haut&sf_cache_key=*');
      }
    }
  }

  public static function clearCacheForUser($id)
  {
    if(($cacheDir = sfConfig::get('sf_template_cache_dir')) != "")
    {
      $cacheDir.="/*/all/sf_cache_partial/*/*/sf_cache_key/user-".$id;
      sfToolkit::clearGlob($cacheDir);
    }
  }

  public static function rebuildGroupsArray($array, $group, $multiple = true, $children = false)
  {
    $groups = $array[$group];
    if($groups == "")
    {
      return $groups;
    }
    $temp = array();
    if($multiple)
    {
      foreach($groups as $g)
      {
        $temp[$g['id']] = $g['name'];
      }
    }
    else
    {
      $temp[$groups['id']] = $groups['name'];
    }
    if($children !== false)
    {
      foreach($array[$children] as $c)
      {
        $temp[$c[$group]['id']] = $c[$group]['name'];
      }
    }
    return $temp;
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
  
  public static function parseMethodOption($method_options, $delimiteur = "|")
  {
    return explode($delimiteur, $method_options);
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
}
?>
