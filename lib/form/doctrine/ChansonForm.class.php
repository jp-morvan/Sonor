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
    unset($this['slug'], $this['playlists_list'], $this['duree'], $this['titre']);
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
      $audio = new audio();
      $infos = $audio->analyze($file);
      tools::pr($infos);
      $values['duree'] = $audio->getDuration();
      $values['duree'] = $audio->getAlbum();
      $values['duree'] = $audio->getArtiste();
      $values['duree'] = $audio->getTitre();
      tools::pr($audio->getDuration());
      tools::pr($audio->getAlbum());
      tools::pr($audio->getArtiste());
      tools::pr($audio->getTitre());
    }
    die();
//    parent::doUpdateObject($values);
  }
  
  private function _getAudioFileMetadatas()
  {
    
  }
}
