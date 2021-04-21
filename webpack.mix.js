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

mix.js('resources/js/app.js', 'public/assets/frontend/js')
    .sass('resources/sass/app.scss', 'public/assets/frontend/css')
    .override(config => {
        config.module.rules.push({
            test: /\.vue$/,
            use: [{
                loader: "vue-svg-inline-loader",
            }]
        })
    })
    .options({
        terser: {
          extractComments: false,
        }
    })
    .webpackConfig({
        resolve: {
            alias: {
                '@assets': path.resolve(__dirname, 'public/assets'),
            },
        }
    });
