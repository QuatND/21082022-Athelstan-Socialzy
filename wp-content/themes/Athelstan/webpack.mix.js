const mix = require('laravel-mix');

// vendor js
mix.js(['./src/js/bootstrap.js'], './js/athelstan-theme.min.js').sourceMaps(false, 'source-map')

// vendor css
mix.styles([
        'node_modules/bootstrap/dist/css/bootstrap.css',
        'node_modules/owl.carousel/dist/assets/owl.carousel.css',
        'node_modules/animate.css/animate.min.css',
        './src/css/boxicons.min.css',
        './src/css/icon.css',
        './src/css/error-404.css',
        './src/css/fonts-web.css',
        './src/css/font-awesome.min.css',
    ],
    './css/athelstan-theme.min.css'
).sourceMaps(false, 'source-map')

// js
mix.combine(
        [
            './src/js/app.js',
        ],
        './js/style.min.js'
    ).sourceMaps(false, 'source-map')
    // css
mix.sass('./src/scss/app.scss', './css/style.min.css').sourceMaps(false, 'source-map').options({
    processCssUrls: false
});

// copy assets
mix.copyDirectory('./src/fonts', './fonts');
//mix.copyDirectory('./src/images', './images');