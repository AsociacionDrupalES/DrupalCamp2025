/**
 * @file
 * Comportamiento de los menús desplegables del header.
 */
(function (Drupal) {
  'use strict';

  Drupal.behaviors.headerMenu = {
    attach: function (context, settings) {
      const menuItems = context.querySelectorAll('.header-menu__item--has-children > .header-menu__link');

      const toggleSubmenu = (link, event) => {
        if (event) {
          event.preventDefault();
        }
        const expanded = link.getAttribute('aria-expanded') === 'true';
        link.setAttribute('aria-expanded', !expanded);
        const submenu = link.nextElementSibling;
        submenu.setAttribute('aria-hidden', expanded);
      };

      menuItems.forEach(link => {
        link.addEventListener('click', function(e) {
          if (window.innerWidth < 1235) {
            toggleSubmenu(this, e);
          }
        });
      });

      if (window.innerWidth < 1235) {
        menuItems.forEach(link => {
          if (
            link.classList.contains('is-active') ||
            link.nextElementSibling.querySelector('.is-active')
          ) {
            toggleSubmenu(link);
          }
        });
      }
    }
  };
})(Drupal);
