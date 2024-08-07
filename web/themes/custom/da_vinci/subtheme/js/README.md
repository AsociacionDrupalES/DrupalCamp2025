JS
--

ginebra.js has the base js for this theme and it isn't recommended to modify
it. In custom.js you can add your new code.

Also, you can add your JS files into this directory.
Once you have your JS files you must choose one of the following steps,
depending on your interests:

- DEFINING A LIBRARY:
  Define all of your asset libraries in ginebra.libraries.yml file in your
  ginebra folder and make sure that it is declared in ginebra.info.yml file.

- OVERRIDING AND EXTENDING LIBRARIES:
  You must go to ginebra.info.yml to override libraries defined in da_vinci.
  libraries.yml. They can be either overridden or extended using
  libraries-override or libraries-extend.

- ATTACHING LIBRARIES TO PAGES:
  Attaching a library via a Twig template:
  You can attach an asset library to a Twig template using the attach_library()
  function in any *.html.twig, file like so:
  {{ attach_library('ginebra/my-library') }}

  Attaching a library to all pages:
  To attach a library to all the pages that use your theme, declare it in your
  theme's *.info.yml file, under the libraries.
  After editing the *.info.yml file, remember to clear the cache so that the
  new information is loaded into Drupal.

  More info:
  https://www.drupal.org/docs/8/theming-drupal-8/adding-stylesheets-css-and-
  javascript-js-to-a-drupal-8-theme
