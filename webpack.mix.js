const { mix } = require('laravel-mix');

mix .js('resources/assets/js/app.js', 'public/js/app.js')
    // .js('resources/assets/js/serviceWorker.js', 'public/js/serviceWorker.js')
    .js('resources/assets/js/slick.js', 'public/js/slick.js')
    .js('resources/assets/js/jquery.slides.js', 'public/js/sliders.js')
    .sass('resources/assets/sass/app.scss', 'public/css/app.css')
    .sass('resources/assets/sass/spectre/spectre.scss', 'public/css/spectre.css');