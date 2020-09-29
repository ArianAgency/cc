const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js(['resources/js/app.js','public/admin/content/js/app.js',
    'public/admin/content/js/bootstrap.min.js',
    'public/admin/content/js/Chart.min.js',

    // 'public/admin/content/js/pace.min.js',
    // 'public/admin/content/js/propper.min.js'
], 'public/js')

    .js('public/admin/content/js/*/*.js', 'public/js/view')
    .js(   'public/admin/content/js/jquery.min.js', 'public/js')
    // .js('public/admin/content/js/Chart.min.js', 'public/js')
    // .js('public/admin/content/js/jquery.min.js', 'public/js')
    // .js('public/admin/content/js/pace.min.js', 'public/js')
    // .js('public/admin/content/js/propper.min.js', 'public/js')

    .sass('resources/sass/app.scss', 'public/css');


//




