<?php

/**
 * Playlist filter form base class.
 *
 * @package    sonor
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePlaylistFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'titre'         => new sfWidgetFormFilterInput(),
      'id_user'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'), 'add_empty' => true)),
      'slug'          => new sfWidgetFormFilterInput(),
      'chansons_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Chanson')),
    ));

    $this->setValidators(array(
      'titre'         => new sfValidatorPass(array('required' => false)),
      'id_user'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('sfGuardUser'), 'column' => 'id')),
      'slug'          => new sfValidatorPass(array('required' => false)),
      'chansons_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Chanson', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('playlist_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addChansonsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.ChansonsPlaylists ChansonsPlaylists')
      ->andWhereIn('ChansonsPlaylists.id_chanson', $values)
    ;
  }

  public function getModelName()
  {
    return 'Playlist';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'titre'         => 'Text',
      'id_user'       => 'ForeignKey',
      'slug'          => 'Text',
      'chansons_list' => 'ManyKey',
    );
  }
}
