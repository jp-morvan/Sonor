<?php

/**
 * ChansonsPlaylists form base class.
 *
 * @method ChansonsPlaylists getObject() Returns the current form's model object
 *
 * @package    sonor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseChansonsPlaylistsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'id_playlist' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Playlist'), 'add_empty' => false)),
      'id_chanson'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Chanson'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'id_playlist' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Playlist'))),
      'id_chanson'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Chanson'))),
    ));

    $this->widgetSchema->setNameFormat('chansons_playlists[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ChansonsPlaylists';
  }

}
