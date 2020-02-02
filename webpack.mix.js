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


mix.js([
  'resources/js/app.js',

], 'public/js')

mix.version();

mix.styles([
  'resources/css/app.css',  
], 'public/css/custom.css')
.styles([
  'resources/css/AdminLTE.css',
],'public/css/AdminLTE.min.css')
.styles([
  'resources/css/_all-skins.css',
],'public/css/_all-skins.min.css')
.sass('resources/sass/toastr.scss', 'public/css')

mix.version();

