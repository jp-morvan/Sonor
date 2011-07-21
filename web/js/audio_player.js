//ArrayAccess = function(data){
//	this.data = data;
//};
//ArrayAccess.prototype = {
//	current: 0,
//	data: [],
//	move: function(n){
//		var l = this.data.length;
//		return this.data[Math.abs(this.current = (this.current + (n ? 1 : l - 1)) % l)];
//	},
//	getNext: function(){
//		return this.move(1);
//	},
//	getPrevious: function(){
//		return this.move(0);
//	},
//	getCurrent: function(){
//		return this.data[this.current];
//	}
//};

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