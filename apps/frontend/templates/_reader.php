<audio id="audio" src="<?php echo $sf_request->getAudioPath() ?>empty.<?php echo $sf_request->getAudioFileType() ?>" controls preload></audio>
<script type="text/javascript">
function test()
{
  var player = document.getElementById('audio');
  var ap = new AudioPlayer(player);
  while(ap.goToNextSong() !== true)
  {
    var wait = ap.getTimeToWaitToTest();
    setInterval(alert,wait);
  }
  alert('Chanson suivante !');
}
</script>
<a onclick="test(); return false;">test</a>