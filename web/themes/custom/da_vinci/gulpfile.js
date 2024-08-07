'use strict';

/****** DEPENDENCIES ********/

var autoprefixer = require('autoprefixer'),
  browserSync = require('browser-sync').create(),
  color = require('colors'),
  del = require('del'),
  gulp = require('gulp'),
  imagemin = require('gulp-imagemin'),
  jsHint = require('gulp-jshint'),
  jsHintStylish = require('jshint-stylish'),
  postCss = require('gulp-postcss'),
  process = require('yargs').argv,
  sass = require('gulp-sass'),
  sassGlob = require('gulp-sass-glob'),
  sassLint = require('gulp-sass-lint'),
  sourceMaps = require('gulp-sourcemaps');

/********** VARIABLES *************/

// Hosts - change localhost for see it in browsersync
var path = 'localhost';

// Paths

var srcAssets = {
  images: 'assets/images/',
  styles: 'assets/sass/'
};

var distAssets = {
  images: 'images/',
  js: 'js/',
  styles: 'css/'
};

/********** TASKS ***************/

gulp.task('default', function () {
  console.log('');
  console.log('Cleaning tasks'.yellow);
  console.log('gulp ' + 'clean:styles'.cyan + '                        ' + '# Clean css files from css directory'.grey);
  console.log('gulp ' + 'clean:images'.cyan + '                        ' + '# Clean image files from images directory'.grey);
  console.log('');
  console.log('Compiling tasks'.yellow);
  console.log('gulp ' + 'imagemin'.cyan + '                            ' + '# Minifiy your images in ./assets/images into ./images'.grey);
  console.log('gulp ' + 'mainStyles:dev'.cyan + '                      ' + '# Compile expanded css except "pages" directory and create a maps file.'.grey);
  console.log('gulp ' + 'pageStyles:dev'.cyan + '                      ' + '# Compile expanded css from "pages" directory exclusively and create a maps file.'.grey);
  console.log('gulp ' + 'mainStyles:pro'.cyan + '                      ' + '# Compile compressed css except "pages" directory, autoprefixer to result.'.grey);
  console.log('gulp ' + 'pageStyles:pro'.cyan + '                      ' + '# Compile compressed css from "pages" directory exclusively, autoprefixer to result.'.grey);
  console.log('');
  console.log('Debugging tasks'.yellow);
  console.log('gulp ' + 'sasslint'.cyan + '                            ' + '# Check sass files looking for a bad code practises .'.grey);
  console.log('gulp ' + 'jshint'.cyan + '                              ' + '# Check js files looking for a wrong syntaxis.'.grey);
  console.log('');
  console.log('Watching tasks'.yellow);
  console.log('gulp ' + 'watch'.cyan + '                              ' + '# Run a defined tasks if any specified files are changed.'.grey);
  console.log('gulp ' + 'watch -h'.cyan + ' yourhost'.green + '       ' + '# Modifies your host to use BrowserSync.'.grey);
  console.log('gulp ' + 'browsersync'.cyan + '                        ' + '# Synchronize browser and device in realtime and reload browser if any specified files are changed.'.grey);
  console.log('');
  console.log('Developing task'.yellow);
  console.log('gulp ' + 'dev:watch'.cyan + '                          ' + '# Run a development task list: imagemin, mainStyles:dev, pagesStyles:dev and watch.'.grey);
  console.log('gulp ' + 'dev:browser'.cyan + '                        ' + '# Run a development task list: imagemin, mainStyles:dev, pagesStyles:dev and browserSync.'.grey);
  console.log('gulp ' + 'pro'.cyan + '                                ' + '# Run a production task list: imagemin, mainStyles:pro, pagesStyles:pro'.grey);
  console.log('');
  console.log('Watching task example'.yellow);
  console.log('gulp ' + 'watch -h'.cyan + ' localhost'.green + '      ' + '# To configure hosts as davinci.local.'.grey);
  console.log('');
});

/************* CLEANING *****************/

// Clean css
gulp.task('clean:styles', function () {
  return del([
    distAssets.styles + '*.css',
    distAssets.styles + 'maps/'
  ]).then(paths => {
    console.log('Deleting css from:', distAssets.styles.magenta, '\n', paths.join('\n').magenta);
  });
});

// Clean images
gulp.task('clean:images', function () {
  return del([
    distAssets.images + '*',
    '!' + distAssets.images + '*.txt',
    '!' + distAssets.images + '*.md'
  ]).then(paths => {
    console.log('Deleting images from:', distAssets.images.magenta, '\n', paths.join('\n').magenta);
  });
});

/************* COMPILING *****************/

// Minify images
gulp.task('imagemin', gulp.series(gulp.parallel('clean:images', () =>
  gulp.src(srcAssets.images + '*')
    .pipe(imagemin([
      imagemin.gifsicle({
        interlaced: true
      }),
      imagemin.mozjpeg({
        progressive: true
      }),
      imagemin.optipng({
        optimizationLevel: 5
      }),
      imagemin.svgo({
        plugins: [
          {
            removeViewBox: true
          },
          {
            cleanupIDs: false
          }
        ]
      })
    ], {
      verbose: true
    }))
    .pipe(gulp.dest(distAssets.images))
)));

// Main styles to development
gulp.task('mainStyles:dev', function () {
  return gulp.src([
      '!' + srcAssets.styles + 'pages/**/*.s+(a|c)ss',
      srcAssets.styles + '**/*.s+(a|c)ss'
  ])
    .pipe(sourceMaps.init())
    .pipe(sassGlob())
    .pipe(sass({
      errLogToConsole: true,
      outputStyle: 'expanded'
    }).on('error', sass.logError))
    .pipe(sourceMaps.write('maps'))
    .pipe(gulp.dest(distAssets.styles))
    .pipe(browserSync.stream());
});

// Pages styles to development
gulp.task('pagesStyles:dev', function () {
  return gulp.src(srcAssets.styles + 'pages/**/*.s+(a|c)ss')
    .pipe(sourceMaps.init())
    .pipe(sassGlob())
    .pipe(sass({
      errLogToConsole: true,
      outputStyle: 'expanded'
    }).on('error', sass.logError))
    .pipe(sourceMaps.write('maps'))
    .pipe(gulp.dest(distAssets.styles))
    .pipe(browserSync.stream());
});

// Main styles to producction
gulp.task('mainStyles:pro', function () {
  return gulp.src([
    '!' + srcAssets.styles + 'pages/**/*.s+(a|c)ss',
    srcAssets.styles + '**/*.s+(a|c)ss'
  ])
  .pipe(sassGlob())
  .pipe(sass({
    errLogToConsole: true,
    outputStyle: 'compressed'
  }).on('error', sass.logError))
  .pipe(postCss([
    autoprefixer({
      browsers: ['> 1%', 'ie 8', 'last 2 versions']
    })
  ]))
  .pipe(gulp.dest(distAssets.styles));
});

// Pages styles to producction
gulp.task('pagesStyles:pro', function () {
  return gulp.src(srcAssets.styles + 'pages/**/*.s+(a|c)ss')
    .pipe(sassGlob())
    .pipe(sass({
      errLogToConsole: true,
      outputStyle: 'compressed'
    }).on('error', sass.logError))
    .pipe(postCss([
      autoprefixer({
        browsers: ['> 1%', 'ie 8', 'last 2 versions']
      })
    ]))
    .pipe(gulp.dest(distAssets.styles));
});

/************* DEBUGGING *****************/

// Sass lint
gulp.task('sasslint', function () {
  return gulp.src(srcAssets.styles + '**/*.s+(a|c)ss')
    .pipe(sassLint({
      options: {
        configFile: 'da_vinci.sass-lint.yml'
      }
    }))
    .pipe(sassLint.format())
    .pipe(sassLint.failOnError());
});

// jsHint
gulp.task('jshint', function () {
  return gulp.src([distAssets.js + '*.js'])
    .pipe(jsHint())
    .pipe(jsHint.reporter(jsHintStylish))
    .pipe(browserSync.stream());
});

/************** DEMONS **********************/

// WATCH
gulp.task('watch', function () {
  gulp.watch(srcAssets.styles + '**/*.s+(a|c)ss', gulp.series(gulp.parallel('mainStyles:dev', 'pagesStyles:dev')))
    .on('change', function (path) {
    console.log('');
    console.log('-> File ' + path.magenta.bold + ' was ' + 'changed'.green + ', running tasks css...');
  });

  gulp.watch(distAssets.js + '**/*.js', gulp.series('jshint'))
    .on('change', function (path) {
      console.log('');
      console.log('-> File ' + path + ' was ' + 'changed'.green + ', running tasks js...');
    });

  gulp.watch(srcAssets.images + '**/*', gulp.series('imagemin'))
    .on('change', function (path) {
      console.log('');
      console.log('-> File ' + path + ' was ' + 'changed'.green + ', running tasks images...');
    });

});

// Browser Sync
gulp.task('browsersync', function () {
  var openPath = 'local';
  if (process.h) {
    path = process.h;
    openPath = 'external';
    console.log(path.green + ' configured as new hosts.'.yellow);
  }
  browserSync.init({
    host: path,
    open: openPath,
    proxy: path
  });
  gulp.watch(srcAssets.styles + '**/*.s+(a|c)ss', gulp.series(gulp.parallel('mainStyles:dev', 'pagesStyles:dev')))
    .on('change', function (path) {
      console.log('');
      console.log('-> File ' + path.magenta.bold + ' was ' + 'changed'.green + ', running tasks...');
      browserSync.reload();
    });
});

/************** TIME TO WORK ***********************/

// Development enviroment
gulp.task('dev:watch', gulp.series(gulp.parallel('imagemin', 'mainStyles:dev', 'pagesStyles:dev', 'watch')));
gulp.task('dev:browsersync', gulp.series(gulp.parallel('imagemin', 'mainStyles:dev', 'pagesStyles:dev', 'browsersync')));

// Production enviroment
gulp.task('pro', gulp.series(gulp.parallel('imagemin', 'mainStyles:pro', 'pagesStyles:pro')));
