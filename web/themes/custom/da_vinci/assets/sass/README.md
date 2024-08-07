SASS
----

Once you have your 'gulp watch' launched, everytime you write in a sass file
and then save, Gulp will save your changes into main.css, so main.css will be
overriden. Or if you have new changes and run 'gulp styles:dev' (for
development enviroment) or 'gulp styles:pro' (production enviroment)
you will be in the same situation.

Sass files are classified into different categories:
· Base: skinr file (which contains typography styles) and susy (which contains
Susy config declaration)
· Components: styles for component elements such as breadcrumbs, pager,
buttons... and other elements you can be used anywhere on the website.
· Layout: styles for layout elements such as header, footer, sidebar...
· Pages: styles for specific kind of pages
· Utils: functions, helpers, mixins and variables.

Feel free to add your own sass files :)

For more info, check main.sass (located in da_vinci/assets/sass)
