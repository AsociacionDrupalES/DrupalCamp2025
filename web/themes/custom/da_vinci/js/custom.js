/**
 * @file
 * Your custom code into javascript behaviour.
 */

(function ($, Drupal, once) {


setTimeout(function() {

	$(".burger-menu").on( "click", function( event ) {
		$(this).toggleClass('active');
		$(".menu-camp").toggleClass('mobile');
		$("body").toggleClass('freeze');
	});


	$('.slider-gallery-dcspain').slick({
		centerMode: true,
		slidesToShow: 3,
    autoplay: true,
    autoplaySpeed: 2000,
		dots: false,
		arrows: true,
		swipe: true,
	  infinite: true,
		swipeToSlide: true,
    responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
	});

	$('.slick-prev').text('<');
	$('.slick-next').text('>');
}, 650);


})(jQuery, Drupal, once);

