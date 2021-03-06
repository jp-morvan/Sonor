<!DOCTYPE html>
<html>
    <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php echo use_javascript('jquery/jquery.alerts.js'); ?>
    <?php echo use_javascript('jquery/notification.js'); ?>
<?php if($sf_user->isAuthenticated()): ?>
      <?php echo use_javascript('/sfFormExtraPlugin/js/jquery.autocompleter.js'); ?>
      <?php echo use_javascript('buzz.js'); ?>
      <?php echo use_javascript('sonor.player.js'); ?>
      <?php echo use_stylesheet('frontend.css'); ?>
      <?php echo use_stylesheet('sonor.player.css'); ?>
<?php else: ?>
      <?php echo use_stylesheet('frontend_not_authenticated.css'); ?>
<?php endif; ?>
    <?php echo use_javascript(url_for('@javascript_functions')); ?>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <header>
      <div id="user_info">
        <div id="logo">
          <a href="<?php echo url_for('@homepage') ?>"><img src="/images/logo-icon.png" alt="" /> <span>Sonor</span></a>
        </div>
        <span id="user"><?php include_partial('global/user_infos') ?></span>
      </div>
<?php if($sf_user->isAuthenticated()): ?>
      <div id="reader">
        <?php include_partial('global/reader') ?>
      </div>
<?php endif; ?>
<?php if($sf_user->isAuthenticated()): ?>
      <div id="search">
        <?php include_component('accueil', 'search') ?>
      </div>
<?php endif; ?>
    </header>
    <div id="page">
<?php if($sf_user->isAuthenticated()): ?>
      <div id="sidebar">
        <?php include_component('accueil', 'sidebar') ?>
      </div>
      <div id="content">
        <?php echo $sf_content ?>
      </div>
<?php endif; ?>
    <div id="clear"></div>
    </div>
    <div id="notification">
      <div class="info message"></div>
      <div class="error message"></div>
      <div class="warning message"></div>
      <div class="success message"></div>
    </div>
  </body>
</html>
