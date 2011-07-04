<?php
/**
 * Description of convert
 *
 * @author JP-MORVAN
 */
class convert
{
  private static $_mp3_command = "ffmpeg -i '%s' -f '%s' -strict experimental -acodec '%s' -aq 50 '`basename '%s' .%s`.%s'",
                 $_ogg_command = "dir2ogg '%s'";

  public $output_format = null,
         $codec = null,
         $file = null;

  public function __construct($file)
  {
    // TODO installer le paquet dir2ogg
    // TODO installer le paquet ffmpeg
    $this->file = $file;
    $input_format = substr(strtolower(strrchr(basename($file), ".")), 1);
    $this->setOutputFileAndCodec($input_format);
  }

  public function doConversion($file)
  {
    $command = $this->getCommand();
    exec($command, $output);
    return $output;
  }
  
  public function getOutputFormat()
  {
    return $this->output_format;
  }
  
  private function getCommand()
  {
    if($this->output_format == 'mp3')
    {
      return sprintf(self::$_mp3_command, 
          $this->file,
          $this->getOutputFormat(),
          $this->codec,
          $this->file,
          $input_format,
          $this->getOutputFormat()
      );
    }
    if($this->getOutputFormat() == 'ogg')
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
