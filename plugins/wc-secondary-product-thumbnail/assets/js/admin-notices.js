jQuery(function($) {
  'use strict';
  
  $('.wcspt-update-notice').on('click', '.notice-dismiss', function() {
    $.ajax({
      url: ajaxurl,
      data: {
        action: 'dismiss_wcspt_update_notice'
      }
    });
  });

});