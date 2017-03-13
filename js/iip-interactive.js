jQuery(document).ready(function($){
  $('.iip_chatroll').click(function(){
    $('.iip_two').toggleClass('minimized');
    $('.iip_chatroll iframe').toggle();
    $('.chatroll_topbar').toggleClass('reduced');
  });

  var deadline = new Date($('#datetime').val());
  initializeClock('clockdiv', deadline);
});

function getTimeRemaining(endtime) {
  var t = Date.parse(endtime) - Date.parse(new Date());
  var seconds = Math.floor((t / 1000) % 60);
  var minutes = Math.floor((t / 1000 / 60) % 60);
  var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
  var days = Math.floor(t / (1000 * 60 * 60 * 24));
  return {
    'total': t,
    'days': days,
    'hours': hours,
    'minutes': minutes,
    'seconds': seconds
  };
}

function initializeClock(id, endtime) {
  var clock = document.getElementById(id);
  var daysSpan = clock.querySelector('.days');
  var hoursSpan = clock.querySelector('.hours');
  var minutesSpan = clock.querySelector('.minutes');
  var secondsSpan = clock.querySelector('.seconds');

  function updateClock() {
    var t = getTimeRemaining(endtime);

    daysSpan.innerHTML = t.days;
    hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
    minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
    secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);
    
    if (t.total <= 0) {
      clearInterval(timeinterval);
    }
    resizeClock();
  }
  
  function resizeClock(){
    var clockWidth = clock.clientWidth;
    var bodyWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0) / 4;
    var fontSize = clockWidth/bodyWidth+'vw';
          
    clock.style.fontSize = fontSize;
  }
  
  updateClock();
  var timeinterval = setInterval(updateClock, 1000);
}