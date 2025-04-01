(function (Drupal) {

  Drupal.behaviors.carousel = {
    attach(context) {
      context.querySelectorAll('.swiper').forEach((element) => {
        const swiper = new Swiper(element, {
          breakpoints: {
            768: {
              slidesPerView: 2.2,
              spaceBetween: 32,
            },
          },
          navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
          },
          pagination: {
            el: '.swiper-pagination',
            clickable: true,
          },
          rewind: true,
          slidesPerView: 1.4,
          spaceBetween: 32,
        });
      });
    },
  };
})(Drupal);
