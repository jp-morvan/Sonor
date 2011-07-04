<?php

class scanConvertAndMoveTask extends sfBaseTask
{
  private $_infos = array(
      'without_metadata' => 0,
      'with_metadata' => 0,
  );
  
  private $_files_converted = array();
  
  protected function configure()
  {
     $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', 'backend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_OPTIONAL, 'The environment', 'prod'),
      new sfCommandOption('debug', null, sfCommandOption::PARAMETER_OPTIONAL, 'use debug mode', 'false'),
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
    $this->list_path = sfConfig::get('app_files_storage_path_list');
    $this->no_metadata_path = sfConfig::get('app_files_storage_path_no_metadata');
    $this->scanAndAnalyse();
    if($options['debug'] == 'true')
    {
      $this->debug();
    }
  }
  
  protected function scanAndAnalyse()
  {
    foreach(scandir($this->todo_path) as $file)
    {
      $path = $this->todo_path.$file;
      if(!is_dir($path))
      {
        if(tools::getFilename($path) != tools::getSlugifyFilename($path))
        {
          $this->move($path, 'todo', tools::getSlugifyFilename($path));
        }
        $path = $this->todo_path.tools::getSlugifyFilename($path);
        $audio = new audio($path);
        if(!$audio->hasTags())
        {
          Chanson::newWithoutTags($audio, $path);
          $this->move($path, 'no_metadata');
          $this->_infos['without_metadata']++;
        }
        else
        {
          $this->chanson = Chanson::newWithTags($audio);
          $this->convert($path);
          $this->_infos['with_metadata']++;
        }
      }
    }
  }
  
  protected function debug()
  {
    foreach($this->_infos as $field => $value)
    {
      $this->logSection('scan', sprintf('%s : %s générés', $field, $value));
    }
    $this->logBlock('Fichiers convertis :', 'QUESTION_LARGE');
    foreach($this->_files_converted as $file)
    {
      $this->logSection('files', sprintf('%s', $file));
    }
  }
  
  
  protected function convert($file)
  {
    $conv = new convert($file);
    $filename = tools::getFilename($file);
    $ogg = tools::getFilenameWithoutExtension($file, false).".".$conv->getOutputFormat();
    $ogg_path = $this->todo_path.$ogg;
    if(!file_exists($ogg_path))
    {
      $conversion = $conv->doConversion();
      $this->_files_converted[] = $filename;
    }
    $this->move($this->todo_path.$filename, 'list');
    $this->move($ogg_path, 'list');
  }
  
  protected function move($file, $path, $new_name = null)
  {
    $this->logSection('move', sprintf('%s in %s', $file, $path));
    tools::moveFileToDir($this->{$path.'_path'}, $file, $new_name);
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
