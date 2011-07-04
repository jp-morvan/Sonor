<?php

/**
 * Artiste form.
 *
 * @package    sonor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ArtisteEmbedForm extends BaseArtisteForm
{
  public function configure()
  {
    unset($this['slug']);
  }
}
