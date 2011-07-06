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
    unset($this['slug'], $this['playlists_list'], $this['duree'], $this['titre'], $this['id_album'], $this['piste'], $this['has_metadata']);
    $this->widgetSchema['audio_file'] = new sfWidgetFormInputFile();
    $this->validatorSchema['audio_file'] = new sfValidatorFile(array(
                                        'required' => true,
                                        'path' => sfConfig::get('app_files_storage_path_todo'),
                               ));
  }

  protected function doUpdateObject($values)
  {
    $file = sfConfig::get('app_files_storage_path_todo').$values['audio_file'];
    if(file_exists($file))
    {
      $audio = new audio($file);
      if($audio->hasTags() && $audio->hasEnoughTags())
      {
        $values['titre'] = $audio->getTag('title');
        $values['duree'] = $audio->getDuration();
        $values['piste'] = $audio->hasTag('track') ? $audio->getTag('track') : null;
        $artiste = Artiste::issetOrCreate($audio->getTag('artist'));
        $values['id_album'] = Album::issetOrCreate($audio->getTag('album'), $artiste);
        $values['has_metadata'] = true;
      }
      else
      {
        $values['titre'] = tools::getFilenameWithoutExtension($audio->getFilename());
      }
    }
    parent::doUpdateObject($values);
  }
}
