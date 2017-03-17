jQuery(document).ready(function($){
  $('.iip_chatroll').click(function(){
    $('.iip_two').toggleClass('minimized');
    $('.iip_chatroll iframe').toggle();
    $('.chatroll_topbar').toggleClass('reduced');
  });

  var deadline = new Date($('#countdatetime').val());
  var clockid = 'clockdiv';

  initializeClock(clockid, deadline);
  resizeClock(clockid);

  $( window ).resize(function() {
    resizeClock(clockid);
  });

  var myCalendar = createCalendar({
    options: {
      class: 'addtocalendar',

      // You can pass an ID. If you don't, one will be generated for you
      id: 'calendar'
    },
    data: {

      // Event title
      title: $('#caltitle').val(),

      // Event start date
      start: new Date($('#caldatetime').val()),

      // Event duration (IN MINUTES)
      duration: $('#calduration').val(),   

      // Event Address
      address: $('#caladdress').val(),

      // Event Description
      description: $('#caldescription').val(),

      // Button text
      text: $('#caltext').val()
      
    }
  });

  document.querySelector('#iip_calendar').appendChild(myCalendar);
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

function resizeClock(id){
  var clock = document.getElementById(id);

  var clockWidth = clock.clientWidth;
  var bodyWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0) / 4;
  var fontSize = clockWidth/bodyWidth+'vw';
        
  clock.style.fontSize = fontSize;
}

function initializeClock(id, endtime) {
  var clock = document.getElementById(id);
  var daysSpan = clock.querySelector('.days');
  var hoursSpan = clock.querySelector('.hours');
  var minutesSpan = clock.querySelector('.minutes');
  var secondsSpan = clock.querySelector('.seconds');

  function updateClock() {
    var t = getTimeRemaining(endtime);

    daysSpan.innerHTML = ( t.days <= 0 ) ? 0 : t.days;
    hoursSpan.innerHTML = ( t.hours <= 0 ) ? '00' : ('0' + t.hours).slice(-2);
    minutesSpan.innerHTML = ( t.minutes <= 0 ) ? '00' : ('0' + t.minutes).slice(-2);
    secondsSpan.innerHTML = ( t.seconds <= 0 ) ? '00' : ('0' + t.seconds).slice(-2);
    
    if (t.total <= 0) {
      clearInterval(timeinterval);
    }

  }
  
  updateClock();
  var timeinterval = setInterval(updateClock, 1000);
}