jQuery(document).ready(function($){
  $('.iip_chatroll').click(function(){
    $('.iip_two').toggleClass('minimized');
    $('.iip_chatroll iframe').toggle();
    $('.chatroll_topbar').toggleClass('reduced');
  });
});