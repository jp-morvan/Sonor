<?php

/**
 * Playlist form base class.
 *
 * @method Playlist getObject() Returns the current form's model object
 *
 * @package    sonor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePlaylistForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'titre'         => new sfWidgetFormInputText(),
      'id_user'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'), 'add_empty' => true)),
      'slug'          => new sfWidgetFormInputText(),
      'chansons_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Chanson')),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'titre'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'id_user'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'), 'required' => false)),
      'slug'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'chansons_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Chanson', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Playlist', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('playlist[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Playlist';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['chansons_list']))
    {
      $this->setDefault('chansons_list', $this->object->Chansons->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveChansonsList($con);

    parent::doSave($con);
  }

  public function saveChansonsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['chansons_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Chansons->getPrimaryKeys();
    $values = $this->getValue('chansons_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Chansons', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Chansons', array_values($link));
    }
  }

}
