<?php

/**
 * accueil actions.
 *
 * @package    sonor
 * @subpackage accueil
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class accueilActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  }

  public function executeSearch(sfWebRequest $request)
  {
    $this->forward404unless($request->isXmlHttpRequest());
    $this->getResponse()->setContentType('application/json');
    $choices = array();
    $chansons = Doctrine::getTable('Chanson')->searchEverything($request->getParameter('q'), $request->getParameter('limit'));
    $albums = Doctrine::getTable('Album')->searchEverything($request->getParameter('q'), $request->getParameter('limit'));
    foreach($chansons as $c)
    {
      $choices['c_'.$c->slug] = '(C) '.$c->titre;
    }
    foreach($albums as $a)
    {
      $choices['c_'.$a->slug] = '(A) '.$a->titre;
    }
    if(count($choices) == 0)
    {
      $choices[] = 'Aucun résultat';
    }
    return $this->renderText(json_encode($choices));
  }

  public function executeJavascript(sfWebRequest $request)
  {
  }
  
  public function executeAjaxLecture(sfWebRequest $request)
  {
    $slug = $request->getParameter('slug');
    $type = $request->getParameter('type');
    if($type == "chanson")
    {
      $chanson = Doctrine_Core::getTable('Chanson')->findOneBy('slug', $slug);
      $path = $chanson->getAlbumDirectory().$chanson->audio_file.".".$request->getAudioFileType();
      $filename = sfConfig::get('app_files_storage_path_list').$path;
      $file = $request->getAudioPath().$path;
      return $this->renderText($file);
    }
    if($type == "album")
    {
      $ids = array();
      // TODO ajouter un order
      $album = Doctrine_Core::getTable('Album')->findOneBy('slug', $slug);
      foreach(($chansons = $album->getChanson()) as $chanson)
      {
        $ids[] = $chanson->slug;
      }
      return $this->renderText(json_encode($ids));
    }
//    $this->getResponse()->clearHttpHeaders();
//    $this->getResponse()->setHttpHeader('Content-Length', filesize($filename));
//    $this->getResponse()->setHttpHeader('Connection', 'Keep-Alive');
//    $this->getResponse()->setContentType('audio/ogg');
//    $this->getResponse()->setContent(file_get_contents($filename));
//    $this->getResponse()->send();
  }
  
  public function executeAjaxListeChansons(sfWebRequest $request)
  {
    $type = $request->getParameter('type');
    $slug = $request->getParameter('slug');
    $chansons = Doctrine_Core::getTable('Chanson')->findForType($type, $slug);
    return $this->renderPartial('accueil/content', array(
        'chansons' => $chansons, 
        'type' => $type, 
        'titre' => $chansons[0][ucfirst($type)]['titre'], 
        'slug' => $slug)
    );
  }
}
