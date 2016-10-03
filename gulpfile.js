process.env.DISABLE_NOTIFIER = true;
var elixir = require('laravel-elixir');
    // elixir.config.assetsPath = 'public';


require('laravel-elixir-ng-annotate');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    // mix.styles([
    // 		'resources/assets/css/assets/bootstrap.min.css',
    // 		'resources/assets/css/assets/font-awesome.css',
    // 		'resources/assets/css/assets/animate.css',
    // 		'resources/assets/css/assets/style.css',
    // 	], 'public/css/assets.css');
    
    // mix.scripts([
    // 	'resources/assets/js/assets/jquery-2.1.1.js',
    // 	'resources/assets/js/assets/bootstrap.min.js',
    // 	'resources/assets/js/assets/angular.min.js',
    // ], 'public/js/assets.js');
    
    mix.scripts([
        'resources/assets/js/services',
    ], 'public/js/tpanel-services.js');

    mix.scripts([
    	'resources/assets/js/controllers',
    ], 'public/js/tpanel-controllers.js');

    mix.scripts([
    	'resources/assets/js/factories',
    ], 'public/js/factories.js');

    mix.scripts([
        'resources/assets/js/directives',
    ], 'public/js/tpanel-directives.js');


    /*
        app minification
     */
    
    // mix.annotate([
    //     'public/js/app.js',
    //     'public/js/config.js',
    //     'public/js/directives.js',
    //     'public/js/tpanel-directives',
    //     'public/js/factories.js',
    //     'public/js/controllers.js',
    //     'tpanel-controllers.js'
    // ], 'public/js/annotated.js');

    // mix.scripts([
    //     'public/js/annotated.js'
    // ], 'public/js/min/app.min.js');



    /*
        plugin minification
     */
    
    // mix.scripts([
    //     // 'public/js/jquery/jquery-2.2.3.js',
    //     'public/js/plugins/jquery-ui/jquery-ui.js',
    //     'public/js/bootstrap/bootstrap.min.js',
    //     'public/js/socket.io.js',
    //     'public/js/plugins/metisMenu/jquery.metisMenu.js',
    //     'public/js/plugins/slimscroll/jquery.slimscroll.min.js',
    //     'public/js/plugins/pace/pace.min.js',
    //     'public/js/inspinia.js',
    //     // 'public/js/angular/angular.min.js',
    //     'public/js/angular/angular-sanitize.js',
    //     // 'public/js/plugins/oclazyload/dist/ocLazyLoad.min.js',
    //     // 'public/js/angular-translate/angular-translate.min.js',
    //     // 'public/js/plugins/angular-notify/angular-notify.min.js',
    //     // 'public/js/ui-router/angular-ui-router.min.js',
    //     // 'public/js/bootstrap/ui-bootstrap-tpls-0.12.0.min.js',
    //     // 'public/js/plugins/angular-idle/angular-idle.js',
    // ], 'public/js/min/assets.min.js');
    
});
