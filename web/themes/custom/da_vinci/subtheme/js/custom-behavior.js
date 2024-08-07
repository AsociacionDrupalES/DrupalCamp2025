/**
 * @file
 * Custom Code of the javascript behaviour.
 */

(function ($, Drupal, once) {
  Drupal.behaviors.CustomBehavior = {
    attach: function (context, settings) {

      once('CustomBehavior', 'html', context).forEach(function (element) {
        // Apply the myCustomBehaviour effect to the elements only once.
      });


    }
  };
})(jQuery, Drupal, once);
