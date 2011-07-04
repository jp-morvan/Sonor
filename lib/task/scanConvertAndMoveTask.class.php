<?php

class scanConvertAndMoveTask extends sfBaseTask
{
  private $_files = array();
  
  protected function configure()
  {
     $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', 'backend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_OPTIONAL, 'The environment', 'prod'),
    ));

    $this->namespace        = 'scan';
    $this->name             = 'convert';
    $this->briefDescription = 'Scan, convertit et déplace les fichiers audio à traiter';
    $this->detailedDescription = <<<EOF
$this->briefDescription
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : 'doctrine')->getConnection();
    $this->todo_path = sfConfig::get('app_files_storage_path_todo');
    $this->mp3_path = sfConfig::get('app_files_storage_path_mp3');
    $this->ogg_path = sfConfig::get('app_files_storage_path_ogg');
    $this->no_metadata_path = sfConfig::get('app_files_storage_path_no_metadata');
    $this->scanAndAnalyse();
//    $this->calcule($arguments);
  }
  
  protected function scanAndAnalyse()
  {
    foreach(scandir($this->todo_path) as $file)
    {
      $path = $this->todo_path.$file;
      if(!is_dir($path))
      {
        $audio = new audio($path);
        if(!$audio->hasTags())
        {
          $this->move($path, 'no_metadata');
        }
      }
    }
  }
  
  protected function convert()
  {
    
  }
  
  protected function move($file, $path)
  {
    exec('mv '.$file.' '.$this->{$path.'_path'}, $output);
    return $output;
  }

  /**
   * Calcule la liste du nombre de menus livré par agent sur le mois sélectionné
   *
   * @param array $arguments  Le mois et l'année à calculer
   */
  /*protected function calcule($arguments)
  {
    $context = sfContext::createInstance($this->configuration);
    $this->configuration->loadHelpers('Partial');
    $mois = $arguments['mois'];
    $annee = $arguments['annee'];
    $start_mktime = mktime(0, 0, 0, $mois, 1, $annee);
    $end_mktime = mktime(0, 0, 0, $mois+1, 0, $annee);
    $subject = 'Ville de Villejuif - Liste du nombre de menus par agent - '.tools::setFrDateWithMonthAndYear($start_mktime);
    $liste = $this->formatArray($start_mktime, $end_mktime);
    
    setlocale(LC_TIME, sfConfig::get('app_culture_locale'));
    $message = $this->getMailer()->compose(
      'no-reply@ville-villejuif.fr',
      array(sfConfig::get('app_configuration_email_facturation')),
      $subject,
      get_partial('commande/mailFacturation', array('mktime' => $start_mktime, 'liste' => $liste))
    );
    
    $message->setContentType('text/html');
    if($this->getMailer()->send($message))
    {
      print("Message envoyé.\n");
    }
    else
    {
      print("Erreur lors de l'envoi du message.\n");
    }
  }*/
}
