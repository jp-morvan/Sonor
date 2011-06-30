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
    $this->widgetSchema['search'] = new sfWidgetFormDoctrineJQueryAutocompleterAndClear(array(
        'model' => 'Chanson',
        'url'   => url_for("@homepage")
    ));
    $this->validatorSchema['search'] = new sfValidatorPass();
  }
}
?>
