<?php use_helper('I18N') ?>

<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" id="form_login">
    <?php echo $form ?>
    <?php /*echo $form['username']->renderLabel() ?>
    <?php echo $form['username']->render(($form['username']->hasError()) ? array('class' => 'error') : array()) ?>
    <?php echo $form['password']->renderLabel() ?>
    <?php echo $form['password']->render(($form['username']->hasError()) ? array('class' => 'error') : array()) ?>
    <?php echo $form['remember']->renderLabel() ?>
    <?php echo $form['remember']->render()*/ ?>
    <input type="submit" value="<?php echo __('Signin', null, 'sf_guard') ?>" id="submit_form_login" />

    <?php $routes = $sf_context->getRouting()->getRoutes() ?>
    <?php if (isset($routes['sf_guard_forgot_password'])): ?>
      <a href="<?php echo url_for('@sf_guard_forgot_password') ?>"><?php echo __('Forgot your password?', null, 'sf_guard') ?></a>
    <?php endif; ?>
</form>