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

mix.styles([
    'public/stisla/assets/css/style.css',
    'public/stisla/assets/css/components.css',
    'public/stisla/modules/jquery-selectric/selectric.css',
    'public/stisla/modules/toastr/toastr-2.1.4/build/toastr.css',
], 'public/css/stisla.css').version();

mix.scripts([
    'public/stisla/assets/js/stisla.js',
    'public/stisla/assets/js/scripts.js',
    'public/stisla/assets/js/custom.js',
    'public/stisla/modules/jquery-selectric/jquery.selectric.min.js',
    'public/stisla/modules/toastr/toastr-2.1.4/build/toastr.min.js',
    'public/js/helpers.js',
], 'public/js/stisla.js').version();