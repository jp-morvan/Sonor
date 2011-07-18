<?php

/**
 * Description of sfGuardFormAjaxSignin
 *
 * @author jp-morvan
 */
class sfGuardFormAjaxSignin extends BasesfGuardFormSignin
{
  public function setup() 
  {
    sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
    parent::setup();
    $this->widgetSchema['username']->setLabel(__('E-Mail', array(), 'sf_guard'));
    $this->widgetSchema['password']->setLabel(__('Password', array(), 'sf_guard'));
    $this->widgetSchema['remember']->setLabel(__('Remember', array(), 'sf_guard'));
  }
}

?>
