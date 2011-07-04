<?php

/**
 * Album form.
 *
 * @package    sonor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AlbumEmbedForm extends BaseAlbumForm
{
  private static $_artiste_label = "Artiste",
                $_new_artiste_label = "Nouvel Artiste";
  
  public function configure()
  {
    unset($this['users_list'], $this['slug']);
    
    $this->widgetSchema['id_artiste'] = new sfWidgetFormDoctrineJQueryAutocompleterAndClear(array(
        'model' => 'Artiste',
        'url'   => url_for("@get_artiste"),
    ));
    
    $this->artiste = new Artiste();
    $new_artiste_form = new ArtisteEmbedForm($this->artiste);
    $this->embedForm('new_artiste', $new_artiste_form);
    
    $this->widgetSchema['id_artiste']->setLabel(self::$_artiste_label);
    $this->widgetSchema['new_artiste']->setLabel(self::$_new_artiste_label);
    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
          new sfValidatorCallback(array('callback' => array($this, 'verifArtiste'))),
    )));
  }

  protected function doUpdateObject($values)
  {
    if($values['new_artiste']['nom'] == "")
    {
      unset(
        $values['new_artiste'],
        $this['new_artiste']
      );
    }
    parent::doUpdateObject($values);
  }

  public function verifArtiste($validator, $values, $arguments)
  {
    if($values['titre'] != "" && $values['id_artiste'] == "" && $values['new_artiste']['nom'] == "")
    {
      $error = new sfValidatorError($this->validatorSchema, 'Il faut remplir soit "'.self::$_artiste_label.'" soit "'.self::$_new_artiste_label.'"');
      throw new sfValidatorErrorSchema($this->validatorSchema, array("id_artiste" => $error));
    }
    if($values['id_artiste'] != "" && $values['new_artiste']['nom'] != "")
    {
      $error = new sfValidatorError($this->validatorSchema, 'Il ne faut pas remplir les deux champs "'.self::$_artiste_label.'" & "'.self::$_new_artiste_label.'" en même temps !');
      throw new sfValidatorErrorSchema($this->validatorSchema, array("id_artiste" => $error));
    }
    return $values;
  }
}
