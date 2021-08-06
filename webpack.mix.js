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
    .sass('resources/sass/app.scss', 'public/css')

    .sass('resources/views/auth/assets/scss/boot.scss', 'public/auth/assets/css/boot.css')
    .sass('resources/views/auth/assets/scss/login.scss', 'public/auth/assets/css/login.css')
    .sass('resources/views/auth/assets/scss/reset.scss', 'public/auth/assets/css/reset.css')

    .copyDirectory('resources/views/auth/assets/images', 'public/auth/assets/images')

    .options({
        processCssUrls: false
    })

    .version();
