<?php

require_once dirname(__FILE__).'/../lib/no_metadataGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/no_metadataGeneratorHelper.class.php';

/**
 * no_metadata actions.
 *
 * @package    sonor
 * @subpackage no_metadata
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class no_metadataActions extends autoNo_metadataActions
{
  public function executeNew(sfWebRequest $request) 
  {
    $this->getUser()->setFlash('error', 'Vous ne pouvez que modifier une chanson ne comportant pas de métadonnées !');
    $this->redirect('@chanson_no_metadata');
  }
}
