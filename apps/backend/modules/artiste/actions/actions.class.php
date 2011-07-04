<?php

require_once dirname(__FILE__).'/../lib/artisteGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/artisteGeneratorHelper.class.php';

/**
 * artiste actions.
 *
 * @package    sonor
 * @subpackage artiste
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class artisteActions extends autoArtisteActions
{
  public function executeSearch(sfWebRequest $request) 
  {
    $this->getResponse()->setContentType('application/json');
    $artistes = array();
    foreach(Doctrine::getTable('Artiste')->getAutocompletion($request->getParameter('q'), $request->getParameter('limit')) as $artiste)
    {
      $artistes[$artiste['id']] = $artiste['nom'];
    }
    return $this->renderText(json_encode($artistes));
  }
}
