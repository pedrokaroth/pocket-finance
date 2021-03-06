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
    /*
    *   APP
    */

    .copyDirectory('resources/img', 'public/img')

    .styles([
        'resources/css/vendor/toastr.css',
        'resources/css/vendor/select2.css'
    ], 'public/assets/css/vendor.css')

    .styles([
        'resources/scss/app.scss'
    ], 'public/assets/css/app.css')

    .scripts([
        'resources/js/app.js'
    ], 'public/assets/js/app.js')

    .scripts([
        'resources/js/vendor/jquery.js',
        'resources/js/vendor/popper.js',
        'resources/js/vendor/bootstrap.js',
        'resources/js/vendor/toastr.js',
        'resources/js/vendor/jquery.mask.js',
        'resources/js/vendor/select2.js',
        'resources/js/vendor/charts.js',
        'resources/js/vendor/highcharts.js'
    ], 'public/assets/js/vendor.js')

    /*
    *   VIEWS
    */

    .scripts([
        'resources/views/app/assets/js/app.js'
    ], 'public/front/assets/js/app.js')

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
