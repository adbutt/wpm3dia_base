/**
 * wpm3dia_bas3
 * http://workpowermedia.com.au
 *
 * Copyright (c) 2016 Adam butterworth
 * Licensed under the GPLv2+ license.
 */
/*jshint -W030 */
;(function(window, document, $, undefined) {
	
  'use strict';
  
	/**
	 * skip-link-focus-fix.js
	 *
	 * Helps with accessibility for keyboard only users.
	 *
	 * Learn more: https://git.io/vWdr2
	 */
	( function() {
		var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
		    is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
		    is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

		if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
			window.addEventListener( 'hashchange', function() {
				var id = location.hash.substring( 1 ),
					element;

				if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
					return;
				}

				element = document.getElementById( id );

				if ( element ) {
					if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
						element.tabIndex = -1;
					}

					element.focus();
				}
			}, false );
		}
	})();

  function initNavigation() {
    // slickNav menu
    $('#primary-menu').slicknav({
      prependTo:'#mobile-menu',
      label: '',
      allowParentLinks: true
    });
  }
  
  // add stepin to animate gallery items
  $('.gallery-item').addClass('step-in');

  var waypoints = $('#adams-test').waypoint(function(direction) {
    console.log(this.element.id + ' hit 25% from top of window');
    this.destroy(); 
  }, {
    offset: '25%',
  });
  
  function initWaypoints() {
    if ($('.animate-section').each(function() {
            var a = $(this);
            a.waypoint(function() {
                a.addClass('animate');
            }, {
                offset: '75%'
            });
        }), $('.wp-step-in-slow').each(function() {
            var a = $(this);
            a.waypoint(function() {
                a.find('.step-in').each(function(a) {
                    var t = $(this);
                    setTimeout(function() {
                        t.addClass('animate');
                    }, 200 * a);
                });
            }, {
                offset: '75%'
            });
      })
    );
  }

  //Modaal Settings - https://github.com/humaan/Modaal
  function initModaals() {
    $('.lightbox').modaal({
      type: 'image'
    });
  }
  
  //Contact Form jQuery Validate - https://github.com/humaan/Modaal
  function initValidate() {
    $('#alcf-contactform').validate();
  }

$(window).on('resize',function(){
  $('.breakout').width(window.innerWidth);
}).trigger('resize');


//ready.init
$(document).on('ready pjax:end', function() {
    initWaypoints();
    initModaals();
    initNavigation();
    initValidate();
});

})(window, document, jQuery);
