jQuery(document).ready(function($){
  $('.iip_toggle').click(function(){
    $('.iip_two').toggleClass('maximized');
    $('.iip_chatroll iframe').toggle();
    $('.chatroll_topbar').toggleClass('reduced');
  });
});