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

mix
    .copyDirectory('resources/img', 'public/img')

    .sass('resources/views/auth/assets/scss/boot.scss', 'public/auth/assets/css/boot.css')
    .sass('resources/views/auth/assets/scss/login.scss', 'public/auth/assets/css/login.css')
    .sass('resources/views/auth/assets/scss/reset.scss', 'public/auth/assets/css/reset.css')

    .sass('resources/views/app/assets/scss/app.scss', 'public/front/assets/css/app.css')
    .sass('resources/views/app/assets/scss/reset.scss', 'public/front/assets/css/reset.css')

    .copyDirectory('resources/views/auth/assets/images', 'public/auth/assets/images')

    .options({
        processCssUrls: false
    })

    .version();
