<?php

/**
 * Chanson form base class.
 *
 * @method Chanson getObject() Returns the current form's model object
 *
 * @package    sonor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseChansonForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'titre'          => new sfWidgetFormInputText(),
      'duree'          => new sfWidgetFormTime(),
      'audio_file'     => new sfWidgetFormInputText(),
      'id_album'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Album'), 'add_empty' => true)),
      'slug'           => new sfWidgetFormInputText(),
      'playlists_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Playlist')),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'titre'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'duree'          => new sfValidatorTime(array('required' => false)),
      'audio_file'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'id_album'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Album'), 'required' => false)),
      'slug'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'playlists_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Playlist', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Chanson', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('chanson[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Chanson';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['playlists_list']))
    {
      $this->setDefault('playlists_list', $this->object->Playlists->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->savePlaylistsList($con);

    parent::doSave($con);
  }

  public function savePlaylistsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['playlists_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Playlists->getPrimaryKeys();
    $values = $this->getValue('playlists_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Playlists', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Playlists', array_values($link));
    }
  }

}
