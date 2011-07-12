<?php
/**
 * Description of SearchForm
 *
 * @author JP-MORVAN
 */
class SearchForm extends BaseForm
{
  public function configure()
  {
    $this->widgetSchema['recherche'] = new sfWidgetFormDoctrineJQueryAutocompleterAndClear(array(
        'model' => 'Chanson',
        'url'   => url_for("@search"),
        'config' => '{ max: 50 }'
    ));
    $this->validatorSchema['recherche'] = new sfValidatorPass();
  }
}
?>
