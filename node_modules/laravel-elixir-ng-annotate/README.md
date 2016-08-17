# laravel-elixir-ng-annotate

Elixir wrapper around gulp-ng-annotate

## Install

```bash
$ npm install --save-dev laravel-elixir-ng-annotate
```

## Usage

```js
var elixir = require('laravel-elixir');

require('laravel-elixir-ng-annotate');

var appScripts = [
  'app/app.js',
  'app/routes.js',
  'app/**/*.js'
];

elixir(function(mix) {
   mix.annotate(appScripts);
});
```

This will annotate and concatenate all your Angular js files, then save the output as annotated.js in your public/js/ directory.

You can then apply the scripts tasks to the annotated.js as follows:

```js
   mix.scripts('annotated.js','public/js/app.js', 'public/js/');
```

Or chain it immediately

```js
    elixir(function(mix) {
       mix.annotate(appScripts).scripts('annotated.js','public/js/app.js', 'public/js/');
    });
```

