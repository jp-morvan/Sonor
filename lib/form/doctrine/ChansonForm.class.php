<?php

/**
 * Chanson form.
 *
 * @package    sonor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ChansonForm extends BaseChansonForm
{
  public function configure()
  {
    unset($this['slug'], $this['playlists_list'], $this['duree'], $this['titre'], $this['id_album'], $this['piste']);
    $this->widgetSchema['audio_file'] = new sfWidgetFormInputFile();
    $this->validatorSchema['audio_file'] = new sfValidatorFile(array(
                                        'required' => true,
                                        'path' => sfConfig::get('app_files_storage_path_todo'),
//                                        'mime_types' => 'web_images',
                               ));
    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
          new sfValidatorCallback(array('callback' => array($this, 'verifType'))),
    )));
  }

  public function verifType($validator, $values, $arguments)
  {
//    tools::pr($this->getObject()->audio_file);
//    $error = new sfValidatorError($this->validatorSchema, 'Il faut remplir au moins un des deux champs "Téléphone" et "Email"');
//    throw new sfValidatorErrorSchema($this->validatorSchema, array("audio_file" => $error));
    return $values;
  }

  protected function doUpdateObject($values)
  {
//    $values['start_time'] = $this->getValueDateTime($values, 'start_time');
//    $values['end_time'] = $this->getValueDateTime($values, 'end_time');
//    unset(
//      $values['date'],
//      $this['date']
//    );
    $file = sfConfig::get('app_files_storage_path_todo').$values['audio_file'];
    if(file_exists($file))
    {
//      $values['titre'] = ;
      $audio = new audio($file);
      if($audio->hasTags())
      {
        $values['titre'] = $audio->getTag('title');
        $values['duree'] = $audio->getTag('duration');
        $artiste = $this->_issetArtisteOrCreate($audio->getTag('artist'));
        $values['id_album'] = $this->_issetAlbumOrCreate($audio->getTag('album'), $artiste);
      }
      //$values['duree'] = $audio->getTitre();
      //tools::pr($audio->getDuration());
      //tools::pr($this->_issetAlbumOrCreate($audio->getAlbum()));
      //tools::pr($audio->getArtiste());
    }
    //die();
    parent::doUpdateObject($values);
  }
  
  private function _issetArtisteOrCreate($artiste)
  {
    if(!is_null($artiste) && ($art = Doctrine_Core::getTable('Artiste')->findOneBy('nom', $artiste)) !== false)
    {
      return $art->id;
    }
    $art = new Artiste();
    $art->nom = $artiste;
    $art->save();
    return $art->id;
  }
  
  private function _issetAlbumOrCreate($album, $artiste_id)
  {
    if(!is_null($album) && ($alb = Doctrine_Core::getTable('Album')->findOneBy('titre', $album)) !== false)
    {
      return $alb->id;
    }
    $alb = new Album();
    $alb->titre = $album;
    $alb->id_artiste = $artiste_id;
    $alb->save();
    return $alb->id;
  }
}
