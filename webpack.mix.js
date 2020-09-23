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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');


mix.js('public/admin/content/js/app.js', 'public/js');




// mix.js('public/admin/content/js/Chart.js', 'public/js');
// mix.js('public/admin/content/js/views/main.js', 'public/js');
//
// // mix.js('public/admin/content/js/pace.min.js', 'public/js');
// mix.js('public/admin/content/js/jquery.min.js', 'public/js');
// mix.js('public/admin/content/js/popper.min.js', 'public/js');
// mix.js('public/admin/content/js/bootstrap.min.js', 'public/js');



