<?php

require_once dirname(__FILE__).'/../lib/albumGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/albumGeneratorHelper.class.php';

/**
 * album actions.
 *
 * @package    sonor
 * @subpackage album
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class albumActions extends autoAlbumActions
{
  public function executeSearch(sfWebRequest $request) 
  {
    $this->getResponse()->setContentType('application/json');
    $albums = array();
    foreach(Doctrine::getTable('Album')->getAutocompletion($request->getParameter('q'), $request->getParameter('limit')) as $album)
    {
      $albums[$album['id']] = $album['titre'];
    }
    return $this->renderText(json_encode($albums));
  }
}
