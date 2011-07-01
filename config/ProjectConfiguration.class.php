<?php

require_once '/home/symfony/SOURCES/symfony-1.4.11/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');
    $this->enablePlugins('sfDoctrineGuardPlugin');
    $this->enablePlugins('sfFormExtraPlugin');
    $this->enablePlugins('vjBrowserDetectionPlugin');
    $this->enablePlugins('sfFirePHPPlugin');
  }
}
