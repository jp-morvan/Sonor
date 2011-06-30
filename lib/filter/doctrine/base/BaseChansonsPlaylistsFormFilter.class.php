<?php

/**
 * ChansonsPlaylists filter form base class.
 *
 * @package    sonor
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseChansonsPlaylistsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_playlist' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Playlist'), 'add_empty' => true)),
      'id_chanson'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Chanson'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id_playlist' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Playlist'), 'column' => 'id')),
      'id_chanson'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Chanson'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('chansons_playlists_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ChansonsPlaylists';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'id_playlist' => 'ForeignKey',
      'id_chanson'  => 'ForeignKey',
    );
  }
}
