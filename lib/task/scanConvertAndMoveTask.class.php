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
    ));
     $this->addOptions(array(
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
    $connection = $databaseManager->getDatabase('doctrine')->getConnection();
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
    $files = tools::scanTree(sfConfig::get('app_files_storage_path_todo'), array('mp3'));
    foreach($files as $file)
    {
        if(tools::getFilename($file) != ($slugify_filename = tools::getSlugifyFilename($file)))
        {
          $this->move($file, 'todo', $slugify_filename);
        }
        $slugify_file = $this->todo_path.$slugify_filename;
        $audio = new audio($slugify_file);
        if(!$audio->hasTags() || !$audio->hasEnoughTags())
        {
          $this->chanson = Chanson::newWithoutTags($audio, $slugify_file);
          $this->move($slugify_file, 'no_metadata');
          $this->_infos['without_metadata']++;
        }
        else
        {
          $this->chanson = Chanson::newWithTags($audio);
          $file_destination = $this->list_path.$this->chanson->getAlbumDirectory();
          tools::mkdir($file_destination);
          $this->convert($slugify_file, $file_destination);
          $this->_infos['with_metadata']++;
        }
    }
  }
  
  
  protected function convert($file, $destination)
  {
    $conv = new convert($file);
    $filename = tools::getFilename($file);
    $converted_filename = tools::getFilenameWithoutExtension($file, false).".".$conv->getOutputFormat();
    $converted_file = $this->todo_path.$converted_filename;
    if(!file_exists($converted_file))
    {
      $conversion = $conv->doConversion();
      $this->_files_converted[] = $filename;
    }
    $this->move($file, $destination);
    $this->move($converted_file, $destination);
  }
  
  protected function move($file, $path, $new_name = null)
  {
    if(isset($this->{$path.'_path'}))
    {
      $path = $this->{$path.'_path'};
    }
    $this->logSection('move', sprintf('%s in %s', $file, $path));
    tools::moveFileToDir($path, $file, $new_name);
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
}
