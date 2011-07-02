<?php
/**
 * Description of convert
 *
 * @author JP-MORVAN
 */
class convert
{
  private static $_command = "ffmpeg -i '%s' -f '%s' -strict experimental -acodec '%s' -aq 50 '`basename '%s' .%s`.%s'" ;

  public $output_format = null,
         $codec = null;

  public function __construct(){}

  public function convert($file)
  {
    $input_format = substr(strtolower(strrchr(basename($file), ".")), 1);
    $this->setOutputFileAndCodec($input_format);
    $command = sprintf(self::$_command, 
        $file,
        $this->output_format,
        $this->codec,
        $file,
        $input_format,
        $this->output_format
    );
    tools::pr($command);
    exec($command, $output);
    return $output;
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
