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
//    $this->widgetSchema['duree'];
    $this->widgetSchema['audio_file'] = new sfWidgetFormInputFile();
    $this->validatorSchema['audio_file'] = new sfValidatorFile(array(
                                        'required' => true,
                                        'path' => sfConfig::get('app_files_storage_path_todo'),
//                                        'mime_types' => 'web_images',
                               ));
  }

  protected function doUpdateObject($values)
  {
//    $values['start_time'] = $this->getValueDateTime($values, 'start_time');
//    $values['end_time'] = $this->getValueDateTime($values, 'end_time');
//    unset(
//      $values['date'],
//      $this['date']
//    );
    parent::doUpdateObject($values);
  }
  
  private function _getAudioFileMetadatas()
  {
    
  }
}
