<?php if($sf_user->isAuthenticated()): ?>
Bonjour <?php echo $sf_user->getGuardUser()->getName() ?>
 <a href="<?php echo url_for('@sf_guard_signout') ?>">Déconnexion</a>
<?php else: ?>
<a href="<?php echo url_for('@sf_guard_signin') ?>">Cliquez ici pour vous identifier</a>
<?php endif; ?>