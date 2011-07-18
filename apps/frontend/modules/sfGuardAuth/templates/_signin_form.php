<?php use_helper('I18N') ?>

<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
    <?php echo $form ?>
    <input type="submit" value="<?php echo __('Signin', null, 'sf_guard') ?>" />

    <?php $routes = $sf_context->getRouting()->getRoutes() ?>
    <?php if (isset($routes['sf_guard_forgot_password'])): ?>
      <a href="<?php echo url_for('@sf_guard_forgot_password') ?>"><?php echo __('Forgot your password?', null, 'sf_guard') ?></a>
    <?php endif; ?>
</form>