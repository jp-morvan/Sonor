<?php

/**
 * Chanson form.
 *
 * @package    sonor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ChansonNoMetadataForm extends BaseChansonForm
{
  public function configure()
  {
    unset($this['slug'], $this['playlists_list']);
    $this->widgetSchema['has_metadata'] = new sfWidgetFormInputHidden(array(), array('value' => true));
    $this->widgetSchema['duree'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['audio_file'] = new sfWidgetFormInputHidden();
    $this->validatorSchema['piste'] = new sfValidatorInteger(array('required' => true));
    $this->widgetSchema['id_album'] = new sfWidgetFormDoctrineJQueryAutocompleterAndClear(array(
        'model' => 'Album',
        'url'   => url_for("@get_album"),
    ));
    $this->album = new Album();
    $new_album_form = new AlbumEmbedForm($this->album);
    $this->embedForm('new_album', $new_album_form);
    
    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
          new sfValidatorCallback(array('callback' => array($this, 'verifAlbum'))),
    )));
  }
  
  public function verifAlbum($validator, $values, $arguments)
  {
    if($values['id_album'] == "" && $values['new_album']['titre'] == "")
    {
      $error = new sfValidatorError($this->validatorSchema, 'Il faut remplir soit "Album" soit "Nouvel Album"');
      throw new sfValidatorErrorSchema($this->validatorSchema, array("id_album" => $error));
    }
    if($values['id_album'] != "" && $values['new_album']['titre'] != "")
    {
      $error = new sfValidatorError($this->validatorSchema, 'Il ne faut pas remplir les deux champs "Album" & "Nouvel Album" en même temps !');
      throw new sfValidatorErrorSchema($this->validatorSchema, array("id_album" => $error));
    }
    return $values;
  }
  
  public function save($con = null)
  {
    $chanson = parent::save($con);
    $values = $this->getValues();
    if($values['id_album'] == "")
    {
      $chanson->id_album = $this->getEmbeddedForm('new_album')->getObject()->getId();
      $chanson->save();
      if($values['new_album']['id_artiste'] == "")
      {
        $album = $this->getObject()->getAlbum();
        $album->id_artiste = $this->getEmbeddedForm('new_album')->getEmbeddedForm('new_artiste')->getObject()->getId();
        $album->save();
      }
    }
    return $chanson;
  }

  protected function doUpdateObject($values)
  {
    if($values['new_album']['titre'] == "")
    {
      unset(
        $values['new_album'],
        $this['new_album']
      );
    }
    parent::doUpdateObject($values);
  }
}
