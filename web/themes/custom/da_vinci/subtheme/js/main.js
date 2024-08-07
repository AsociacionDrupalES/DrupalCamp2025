/**
 * @file
 * Custom Code of the javascript behaviour.
 */

(function ($, Drupal, once) {
  Drupal.behaviors.subthemeBehavior = {
    attach: function (context, settings) {

      once('subthemeBehavior', 'html', context).forEach(function (element) {
        // Apply the subthemeBehaviour effect to the elements only once.
      });

    }
  };
})(jQuery, Drupal, once);
