
var Encore = require('@symfony/webpack-encore');
var webpack = require('webpack');

Encore
    .setOutputPath('web/build')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .addEntry('app', './assets/js/main.js')
    .addStyleEntry('global', './assets/css/global.scss')
    .enableSassLoader(function (sassOptions) {}, {
        resolve_url_loader: false
    })
    .enablePostCssLoader()
    .autoProvidejQuery()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning()
    .configureBabel(function (babelConfig) {
        babelConfig.presets.push('es2017');
        babelConfig.plugins = ['styled-jsx/babel'];
    })
    .enableReactPreset()
    .addPlugin(new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/))
;

module.exports = Encore.getWebpackConfig();

