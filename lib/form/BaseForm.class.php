<?php

/**
 * Base project form.
 * 
 * @package    sonor
 * @subpackage form
 * @author     Your name here 
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class BaseForm extends sfFormSymfony
{
  public function setup() 
  {
    sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'Date', 'Url'));
    $this->required = __('Required.', array(), 'vjAuthLogin');
    $this->invalid = __('Invalid.', array(), 'vjAuthLogin');
    $this->nan = __('"%value%" is not an integer.', array(), 'vjAuthLogin');
    sfValidatorBase::setDefaultMessage('required', $this->required);
    sfValidatorBase::setDefaultMessage('invalid', $this->invalid);
  }
}
