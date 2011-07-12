<?php
/**
 * Description of SearchForm
 *
 * @author JP-MORVAN
 */
class AlbumFieldForm extends BaseForm
{
  public function configure()
  {
    $this->widgetSchema['album'] = new sfWidgetFormDoctrineJQueryAutocompleterAndClear(array(
        'model' => 'Album',
        'url'   => url_for("@search", array('type' => 'album')),
        'config' => '{ max: 10 }'
    ));
    $this->validatorSchema['album'] = new sfValidatorPass();
  }
}
?>
