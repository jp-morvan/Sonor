<?php

/**
 * Project form base class.
 *
 * @package    sonor
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormBaseTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class BaseFormDoctrine extends sfFormDoctrine
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
