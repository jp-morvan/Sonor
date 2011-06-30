function AudioPlayer(elt)
{
  var elt;

  this.getCurrentTime = function ()
  {
    return this.elt.currentTime;
  }

  this.getDuration = function ()
  {
    return this.elt.duration;
  }

  this.getTimeToWaitToTest = function ()
  {
    return this.getDiffBetweenDurationAndCurrentTime();
  }

  this.getDiffBetweenDurationAndCurrentTime = function ()
  {
    return (this.getDuration() - this.getCurrentTime());
  }
  
  this.goToNextSong = function()
  {
    return (this.getDiffBetweenDurationAndCurrentTime() <= 0);
  }
  
  this.elt = elt;
}