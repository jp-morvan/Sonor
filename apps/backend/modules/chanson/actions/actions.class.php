<?php

require_once dirname(__FILE__).'/../lib/chansonGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/chansonGeneratorHelper.class.php';

/**
 * chanson actions.
 *
 * @package    sonor
 * @subpackage chanson
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class chansonActions extends autoChansonActions
{
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

      try {
        $chanson = $form->save();
      } catch (Doctrine_Validator_Exception $e) {

        $errorStack = $form->getObject()->getErrorStack();

        $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ?  's' : null) . " with validation errors: ";
        foreach ($errorStack as $field => $errors) {
            $message .= "$field (" . implode(", ", $errors) . "), ";
        }
        $message = trim($message, ', ');

        $this->getUser()->setFlash('error', $message);
        return sfView::SUCCESS;
      }

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $chanson)));

      if($chanson->has_metadata === true)
      {
        if ($request->hasParameter('_save_and_add'))
        {
          $this->getUser()->setFlash('notice', $notice.' You can add another one below.');

          $this->redirect('@chanson_new');
        }
        else
        {
          $this->getUser()->setFlash('notice', $notice);

          $this->redirect(array('sf_route' => 'chanson_edit', 'sf_subject' => $chanson));
        }
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice.' No medatada found, please add some.');

        $this->redirect('@chanson_no_metadata_edit?id='.$chanson->id);
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
  }
}
