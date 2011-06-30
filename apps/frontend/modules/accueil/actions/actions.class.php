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

  public function executeJavascript(sfWebRequest $request)
  {
  }
  
  public function executeAjaxLecture(sfWebRequest $request)
  {
    $type = $request->getParameter('type');
    $slug = $request->getParameter('slug');
    $chanson = Doctrine_Core::getTable('Chanson')->findOneBy('slug', $slug);
    $path = substr(sfConfig::get('app_files_storage_path'), strlen(sfConfig::get('sf_web_dir')));
    return $this->renderText($path.$chanson->audio_file);
  }
  
  public function executeAjaxListeChansons(sfWebRequest $request)
  {
    $type = $request->getParameter('type');
    $slug = $request->getParameter('slug');
    $chansons = Doctrine_Core::getTable('Chanson')->findForType($type, $slug);
    return $this->renderPartial('accueil/content', array('chansons' => $chansons));
  }
}
