<?php if($sf_user->isAuthenticated()): ?>
Bonjour <?php echo $sf_user->getGuardUser()->getName() ?> !
<?php if($sf_user->isSuperAdmin()): ?>
  <a href="<?php echo (($env = $sf_context->getConfiguration()->getEnvironment()) != "prod")? "/backend_".$env.".php" : "" ?>/admin/">Administration</a> | 
<?php endif; ?>
  <a href="<?php echo url_for('@sf_guard_signout') ?>" id="logout">Déconnexion</a>
<?php else: ?>
  <a id="login">Cliquez ici pour vous identifier</a>
<?php endif; ?>