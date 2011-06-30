<?php

/**
 * Chanson filter form base class.
 *
 * @package    sonor
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseChansonFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'titre'          => new sfWidgetFormFilterInput(),
      'duree'          => new sfWidgetFormFilterInput(),
      'audio_file'     => new sfWidgetFormFilterInput(),
      'id_album'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Album'), 'add_empty' => true)),
      'slug'           => new sfWidgetFormFilterInput(),
      'playlists_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Playlist')),
    ));

    $this->setValidators(array(
      'titre'          => new sfValidatorPass(array('required' => false)),
      'duree'          => new sfValidatorPass(array('required' => false)),
      'audio_file'     => new sfValidatorPass(array('required' => false)),
      'id_album'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Album'), 'column' => 'id')),
      'slug'           => new sfValidatorPass(array('required' => false)),
      'playlists_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Playlist', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('chanson_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addPlaylistsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('ChansonsPlaylists.id_playlist', $values)
    ;
  }

  public function getModelName()
  {
    return 'Chanson';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'titre'          => 'Text',
      'duree'          => 'Text',
      'audio_file'     => 'Text',
      'id_album'       => 'ForeignKey',
      'slug'           => 'Text',
      'playlists_list' => 'ManyKey',
    );
  }
}
