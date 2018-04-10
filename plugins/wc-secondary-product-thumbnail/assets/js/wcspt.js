jQuery(function($) {
  'use strict';
  
  var $wcsptProducts = $('.products').has('.wcspt-has-gallery');
  
  if ($wcsptProducts.length) {
    var s = (document.body || document.documentElement).style;
    var transitionsSupported = 'transition' in s || 'WebkitTransition' in s || 'MozTransition' in s || 'OTransition' in s;
    
    if (transitionsSupported) {
      $wcsptProducts.addClass('wcspt-products')
        .find('.wcspt-has-gallery .wcspt-secondary-img').removeClass('wcspt-ie8-tempfix');
      
      if (!checkImg()) {
        $('.wcspt-has-gallery .wcspt-secondary-img', $wcsptProducts).closest('a').addClass('wcspt-img-link');
      }
      
    // Support: IE <=9 and other legacy browsers
    } else {
      $('.wcspt-has-gallery .wcspt-secondary-img', $wcsptProducts).css({ opacity: 0, transition: 'none' })
        .removeClass('wcspt-transition wcspt-ie8-tempfix')
        .closest('a').hover(
          function() {
            $(this).find('.wcspt-secondary-img').stop(true, false).animate({ opacity: 1 }, 250);
          }, function() {
            $(this).find('.wcspt-secondary-img').animate({ opacity: 0 }, 250);
          }
        );
    }
  }
  
  function checkImg() {
    var bool = false;
    
    try {
      bool = document.querySelector('.products .wcspt-has-gallery a:first-of-type .wcspt-transition') !== null;
    } catch (e) {}
    
    return bool;
  }

});