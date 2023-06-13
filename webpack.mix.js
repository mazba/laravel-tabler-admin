const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/tabler.js', 'public/js')
    .js('resources/js/apexcharts.min.js', 'public/js')
    .js('resources/js/jquery.tagsinput-revisited.js', 'public/js')
    .sass('resources/scss/tabler.scss', 'public/css/app.css');
mix.copyDirectory('resources/static', 'public/static');
mix.copyDirectory('resources/img', 'public/img');

