(function (Drupal) {

  Drupal.behaviors.accordion = {
    attach(context) {
      context.querySelectorAll('.accordion-link').forEach((element) => {
        element.addEventListener('click', (event) => {
          event.preventDefault();
          const parent = event.target.closest('.accordion-element');
          const content = parent.querySelector('.accordion-content');
          if (parent.classList.contains('accordion-element--open')) {
            content.style.height = content.scrollHeight + 'px';
            requestAnimationFrame(() => {
              content.style.height = '0';
            });
            parent.classList.remove('accordion-element--open');
          }
          else {
            content.style.height = content.scrollHeight + 'px';
            parent.classList.add('accordion-element--open');
          }
          return false;
        });
      });
    },
  };

})(Drupal);
