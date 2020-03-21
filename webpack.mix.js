const mix = require('laravel-mix');
const CompressionPlugin = require('compression-webpack-plugin');
require('laravel-mix-bundle-analyzer');

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
    .sass('resources/sass/index.scss', 'public/css')
    .sass('resources/sass/postcard.scss', 'public/css')
    .version()
    .browserSync({
    proxy: "localhost:8081",
    files: [
        './resources/views/**/*.blade.php',
        './public/css/*.css',
        './public/js/*.js'
    ]})
    .webpackConfig({
        output: {
          chunkFilename: '[name].chunk.js',
          publicPath: '/',
        },
    })
    .webpackConfig({
        plugins: [
            new CompressionPlugin({
                filename: '[path].gz[query]',
                algorithm: 'gzip',
                test: /\.js$|\.css$|\.html$|\.svg$/,
                threshold: 10240,
                minRatio: 0.8,
            })
        ]
    });

/*
if (!mix.inProduction()) {
    mix.bundleAnalyzer();
}
*/