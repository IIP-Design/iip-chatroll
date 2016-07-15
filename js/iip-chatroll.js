jQuery(document).ready(function($){
  $('.icon').click(function(){
    $('.two').toggleClass('maximized');
    $('.iip_chatroll iframe').toggle();
  });
});