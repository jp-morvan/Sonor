<!DOCTYPE html>
<html>
    <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <?php if($sf_user->isAuthenticated()): ?>
      <?php echo dynamic_javascript_include_tag('@javascript_functions'); ?>
    <?php endif; ?>
  </head>
  <body>
    <header>
      <div id="reader">
        <?php include_partial('global/reader') ?>
      </div>
      <div id="user_info">
        <?php include_partial('global/user_infos') ?>
      </div>
      <div id="logo"><img src="/images/logo.png" alt="Sonor" /></div>
      <div id="search">
        <?php include_component('accueil', 'search') ?>
      </div>
    </header>
    <div id="page">
      <div id="sidebar">
        <?php include_component('accueil', 'sidebar') ?>
      </div>
      <div id="content">
        <?php echo $sf_content ?>
      </div>
    </div>
    <div id="notification">
      <div class="info message"></div>
      <div class="error message"></div>
      <div class="warning message"></div>
      <div class="success message"><h1>dsqdqsdq</h1></div>
    </div>
  </body>
</html>
