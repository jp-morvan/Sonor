<?php

/**
 * Album filter form base class.
 *
 * @package    sonor
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAlbumFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'titre'      => new sfWidgetFormFilterInput(),
      'id_artiste' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Artiste'), 'add_empty' => true)),
      'slug'       => new sfWidgetFormFilterInput(),
      'users_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
    ));

    $this->setValidators(array(
      'titre'      => new sfValidatorPass(array('required' => false)),
      'id_artiste' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Artiste'), 'column' => 'id')),
      'slug'       => new sfValidatorPass(array('required' => false)),
      'users_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('album_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addUsersListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.AlbumsUsers AlbumsUsers')
      ->andWhereIn('AlbumsUsers.id_user', $values)
    ;
  }

  public function getModelName()
  {
    return 'Album';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'titre'      => 'Text',
      'id_artiste' => 'ForeignKey',
      'slug'       => 'Text',
      'users_list' => 'ManyKey',
    );
  }
}
