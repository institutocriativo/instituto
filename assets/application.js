// This is a manifest file that'll be compiled into application.js, which will include all the files
// listed below.
//
// Any JavaScript/Coffee file within this directory, lib/assets/javascripts, or any plugin's
// vendor/assets/javascripts directory can be referenced here using a relative path.
//
// It's not advisable to add code directly here, but if you do, it'll appear at the bottom of the
// compiled file. JavaScript code in this file should be added after the last require_* statement.
//
// Read Sprockets README (https://github.com/rails/sprockets#sprockets-directives) for details
// about supported directives.
//

$(document).ready(function(){
  $('#menu-button-mobile').on('click', function(e){
    e.preventDefault();
    console.log("teste");
    $('.header-menu').slideToggle();
  });

  $('a[href^="#"].destinations').on('click', function(e) {
      var target = $(this.getAttribute('href'));
      if( target.length ) {
          e.preventDefault();
          $('html, body').stop().animate({
              scrollTop: target.offset().top
          }, 1000);
      }
  });
});
