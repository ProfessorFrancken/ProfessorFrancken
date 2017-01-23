let mix = require('laravel-mix').mix;

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

// Though we don't currently use mix to compile our javascript, mix will throw
// an exception if we do not call .js at least once, hence we compile an
// empty javascript file.
mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/red.scss', 'public/css')
    .sass('resources/assets/sass/slef.scss', 'public/css')
    .version();
