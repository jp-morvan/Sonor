<?php
/**
 * Description of convert
 *
 * @author JP-MORVAN
 */
class convert
{
  private static $_mp3_command = "ffmpeg -i '%s' -f '%s' -strict experimental -acodec '%s' -aq 50 '`basename '%s' .%s`.%s'",
                 $_ogg_command = "dir2ogg %s";

  public $output_format = null,
         $codec = null,
         $file = null;

  public function __construct(){}

  public function convert($file)
  {
    $this->file = $file;
    $input_format = substr(strtolower(strrchr(basename($file), ".")), 1);
    $this->setOutputFileAndCodec($input_format);
    $command = $this->getCommand($format);
    tools::pr($command);
    //exec($command, $output);
    //return $output;
  }
  
  private function getCommand($format)
  {
    if($format == 'mp3')
    {
      return sprintf(self::$_mp3_command, 
          $this->file,
          $this->output_format,
          $this->codec,
          $this->file,
          $input_format,
          $this->output_format
      );
    }
    if($format == 'ogg')
    {
      return sprintf(self::$_ogg_command, $this->file);
    }
  }

  private function setOutputFileAndCodec($input_format)
  {
    if($input_format == "mp3")
    {
      $this->output_format = 'ogg';
      $this->codec = 'vorbis';
    }
    else
    {
      $this->output_format = 'mp3';
      $this->codec = 'm4a';
    }
  }
}
?>
