let mix = require('laravel-mix');

let webpackConfig = {
    resolve: {
        alias: {
            'orchid': path.resolve(`${__dirname}/../../../`, 'vendor/orchid'),
        },
    },
};

if (!mix.inProduction()) {
    mix.sourceMaps();
    webpackConfig.devtool = 'source-map'
} else {
    mix.version();
}

mix.webpackConfig(webpackConfig);

mix
    .sass('resources/sass/app.scss', 'css/flexible_content.css')
    .js('resources/js/app.js', 'js/flexible_content.js')
    .setPublicPath('public');
