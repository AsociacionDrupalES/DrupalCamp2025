/**
 * @file
 * Comportamiento de los menús desplegables del header.
 */
(function (Drupal) {
  'use strict';

  Drupal.behaviors.headerMenu = {
    attach: function (context, settings) {
      const toggleButtons = context.querySelectorAll('.header-menu__toggle');

      toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
          const expanded = this.getAttribute('aria-expanded') === 'true' || false;
          this.setAttribute('aria-expanded', !expanded);
        });
      });
    }
  };
})(Drupal);
