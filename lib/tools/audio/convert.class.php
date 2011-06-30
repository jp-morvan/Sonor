<?php
/**
 * Description of convert
 *
 * @author JP-MORVAN
 */
class convert
{
  private static $_command = 'ffmpeg -i "%s" -f %s -strict experimental -acodec %s -aq 50 "`basename "%s" .%s`.%s"';

  public $file,
         $input_format,
         $output_format,
         $codec;

  public function __construct($file)
  {
    $this->file = $file;
    $this->input_format = substr(strtolower(strrchr(basename($file), ".")), 1);
    $this->setOutputFileAndCodec();
  }

  public function execute()
  {
    $command = sprintf(self::$_command, array(
        $this->file,
        $this->output_format,
        $this->codec,
        $this->file,
        $this->input_format,
        $this->output_format,
    ));
    exec($command);
  }

  private function setOutputFileAndCodec()
  {
    if($this->input_format == "mp3")
    {
      $this->output_format = 'ogg';
      $this->codec = 'vorbis';
    }
    $this->output_format = 'mp3';
    $this->codec = 'm4a';
  }
}
?>
