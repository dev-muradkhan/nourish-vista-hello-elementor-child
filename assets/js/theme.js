jQuery(document).ready(function($) {
  const $header = $('.desktop-header'); // Replace '.site-header' with the actual CSS class of your header
  const $headerMobile = $('.headerMobile');
  const scrollThreshold = 200; // Adjust this value (in pixels)

  $(window).scroll(function() {
    if ($(this).scrollTop() > scrollThreshold) {
      $header.addClass('scrolled-header'); // 'scrolled-header' is the class you want to add
	  $headerMobile.addClass('scrolled-header'); // 'scrolled-header' is the class you want to add
    } else {
      $header.removeClass('scrolled-header');
	  $headerMobile.removeClass('scrolled-header');
    }
  });
});