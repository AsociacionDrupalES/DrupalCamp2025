/**
 * @file
 * Da Vinci Custom Code of the javascript behaviour.
 */

(function ($, Drupal, once) {
  Drupal.behaviors.dvBehavior = {
    attach: function (context, settings) {

			$('.plat-group').each(function() {
				var $thisGroup = $(this);
				var $pElements = $thisGroup.find('p');

				$pElements.sort(function() {
					return Math.random() - 0.5;
				});
        $pElements.detach().appendTo($thisGroup);
				// Quitar opacidad después de reorganizar con una animación
				$thisGroup.animate({ opacity: 1 }, 500); // 1000ms es la duración de la animación
		  });

			$(".disable-sub").on( "click", function( event ) {
				event.preventDefault();
			});


/*
$(window).on('scroll', function() {
    var $section = $('.section-circular');
    var positionFromBottom = $(document).height() - $section.offset().top - $(window).scrollTop() - $section.height() - 200;

    // Comprueba si la sección está a 300px de la parte inferior de la ventana
    if(positionFromBottom < 0) {
        // Muestra un alerta la primera vez que esto sucede
        if(!$section.hasClass('animated')) {
            $section.addClass('animated');

            // Aplica una animación de desplazamiento de abajo hacia arriba
            $section.animate({
                'bottom': '0'
            }, 3000); // Duración de la animación
        }
    }
});

*/



      once('dvBehavior', 'html', context).forEach(function (element) {
		  $('.accordion-list > li > .answer').hide();
				
			$('.accordion-list h2').click(function() {
				if ($(this).parent().hasClass("active")) {
					$(this).parent().removeClass("active").find(".answer").slideUp();
				} else {
					$(".accordion-list > li.active .answer").slideUp();
					$(".accordion-list > li.active").removeClass("active");
					$(this).parent().addClass("active").find(".answer").slideDown();
				}
				return false;
		  });
        // Apply the myCustomBehaviour effect to the elements only once.
      });

      $(window).on('resize.rwdElements orientationchange', function () {
        setTimeout(function() {
          $('.slick-prev').text('<');
          $('.slick-next').text('>');
        }, 650);

        if (window.matchMedia('(min-width: 1170px)').matches) {
          $('.menu-camp .bg-faq').after($('.language-switcher-language-url'));
        }else if(window.matchMedia('(max-width: 1169px)').matches){
          $('.menu-camp .bg-ticket').after($('.language-switcher-language-url'));
          $(".burger-menu").removeClass('active');
          $(".menu-camp").removeClass('mobile');
          $("body").removeClass('freeze');
        }
      });

      // Trigger the check for the windows width.
      $(window).trigger('resize.rwdElements');



    }
  };
})(jQuery, Drupal, once);
