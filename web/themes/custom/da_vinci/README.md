INTRODUCTION
------------
Da Vinci is a modern and powerful starter theme with component-based Sass 
and a mobile-first response. Accessible as a rule, it is standards compliant 
and you will find it much easier to start with Da Vinci than start with 
Bartik or Stark, even faster and easier than Bootstrap. This Theme has a 
documentation where each file is explained, examples and useful code 
comments in Twig, Sass and JavaScript are added.

REQUIREMENTS
------------
1.- Npm, which is installed with Node.js, which means that when you download
Node.js, you automatically get npm installed on your computer.
  To install Node.js v14:
    https://nodejs.org/es/download/
      or
    curl -sL https://deb.nodesource.com/setup_14.x | sudo -E bash -
    sudo apt-get install -y nodejs

  Verify that Node.js and npm have been installed correctly:
    node -v
    npm -v

  To update npm version:
    npm install npm@latest -g

  If they are ok, that commands will show us the versions.

INSTALLATION
------------
1.- Take a look at 'REQUIREMENTS' section above. You need all of these things.

2.- Read the 'USAGE' part and create your own subtheme.

3.- Go to your subtheme directory and install bower/npm dependencies:
  cd path-to-your-drupal/themes/custom/MYTHEMENAME
  npm install
  (Maybe you need to use 'sudo')

You're done :)


QUICK START
-----------
1.- CREATING A SUBTHEME:
You should never modify a theme that is packaged and released from Drupal.org
because, if you do, all your changes will be lost once that theme is updated.
Instead, you should create a subtheme. Once you've done that, you can override
styles, templates...

2.- USING GULP:
To launch Gulp, you only need to go to your subtheme directory and then write
'gulp' in command line.
This command displays all the ways for use gulp.

You can choose the command "gulp watch" too, which is much better so it shows
which files have been overriden and, if there were any, show errors.

3.- OVERRIDING AND ADDING STYLES:
Once you have your 'Gulp watch' launched, everytime you write in a sass/js file
and then save, Gulp will save your changes into main.css.
If you're not using 'gulp watch', you should do 'gulp styles:dev' (in a
development enviroment) after each change, then Gulp will compile once your
changes.

IMPORTANT: Remember don't edit the main.css files, because your changes will
be removed when Gulp compiles.

For more info, check README in /src and /assets/sass directory.

4.- OVERRIDING TEMPLATES:
Da Vinci is using Classy as base theme so an override is as simple as copying
one of Classy's templates into your templates directory.

More info in templates directory (README.md file)

5.- PREPROCESS:
You can affect the output of certain HTML via preprocess functions. For example,
 if you wanted to add a class to a menu and preferred to do this at the PHP
 level you can.

The main role of the preprocessors is to set up variables to be placed within
the template. If you need to preprocess theme variables for templates, you only
need to implement hooks for the chosen template in da_vinci.theme file.
- Create a function such as da_vinci_preprocess_HOOK where HOOK refers to the
item you wish to affect.
- Write your changes and save.
- Rebuild the cache so your changes are available.

FILES INFORMATION
-----------------
In each directory you can read information about it and its files. Let's talk
about some files in our theme root directory!

JSON FILES
  - package.json: Npm dependencies, for 'npm install'. If you want a new
  dependency for your project 'npm install your-dependency --save' will save
  your dependency in this file.
  - composer.json: File to install Da Vinci with composer 

GULP FILE
  - gulpfile.js: Here we have all our tasks that we can do with Gulp. Write
  'gulp' in your terminal and read some help about our tasks.

YML/PHP FILES
  - da_vinci.breakpoints.yml: Define Da Vinci breakpoints (Important for
  responsive).
  - da_vinci.info.yml: The main file of our theme. We define name, version,
  base theme... Also we define our regions, and call to our css/js libraries.
  - da_vinci.libraries.yml: To define our css and js libraries.
  - da_vinci.theme: See 'USAGE 5.- Preprocess' for more info.
  - theme-settings.php: Config and Da Vinci settings that you can admin in
  admin/appearance/settings/da_vinci

IMG FILES
  - favicon.ico: Favicon, you can override or add your own in the Da Vinci
  settings.
  - logo.svg: Default logo, you can override or add your own in the Da Vinci
  settings.
  - screenshot.png: The main image of the theme that you see in Appearance,
  you can override for add your own.

MAINTAINERS
-----------
Current maintainers:
 * Nesta Guerrero (nguerrero) - https://www.drupal.org/u/nguerrero
