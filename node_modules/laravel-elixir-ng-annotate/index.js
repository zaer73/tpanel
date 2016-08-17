var gulp    = require('gulp');
var Elixir = require('laravel-elixir');
var ngAnnotate = require('gulp-ng-annotate');

var config = Elixir.config;
var $ = Elixir.Plugins;


/*
 |----------------------------------------------------------------
 | Stylus Compilation Task
 |----------------------------------------------------------------
 |
 | This task will compile your Stylus, including minification and
 | and auto-prefixing. Additionally it supports any postStylus
 | plugins that you want to include with your compilation.
 |
 */

Elixir.extend('annotate', function(scripts, output, baseDir) {
  var paths = prepGulpPaths(scripts, baseDir, output);

  new Elixir.Task('annotate', function () {
    return gulp.src(paths.src.path)
        .pipe(ngAnnotate())
        .pipe($.concat(paths.output.name))
        .pipe(gulp.dest(paths.output.baseDir))
        .pipe(new Elixir.Notification('Scripts Annotated!'));
  })
  .watch(paths.src.path)
  .ignore(paths.output.path);

});


/**
 * Prep the Gulp src and output paths.
 *
 * @param {string|array} src
 * @param {string|null}  baseDir
 * @param {string|null}  output
 */
var prepGulpPaths = function(src, baseDir, output) {
    return new Elixir.GulpPaths()
        .src(src, baseDir || config.get('assets.js.folder'))
        .output(output || config.get('public.js.outputFolder'), 'annotated.js');
};
