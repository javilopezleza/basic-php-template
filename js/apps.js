$(document).ready(function () {
  $('.to-top').click(function () {
    $('body, html').animate({
      scrollTop: '0px'
    }, 000);
  });

  $(window).scroll(function () {
    if ($(this).scrollTop() > 0) {
      $('.to-top').slideDown(300);
    } else {
      $('.to-top').slideUp(300);
    }
  });
});

$(document).ready(function() {
  var referrer =  document.referrer;
});



