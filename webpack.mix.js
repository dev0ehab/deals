const mix = require('laravel-mix'),
    WebpackRTLPlugin = require('webpack-rtl-plugin');
const folder = {
    src: "Modules/Dashboard/Resources/assets/", // source files
    installSrc: "Modules/Installer/Resources/assets/", // source files
    dist_assets: "public/", //build assets files
    dist_backend_assets: "public/backend/", //build assets files
};
require('dotenv').config();
require("mix-env-file");
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

// copy all images
var out = folder.dist_assets + "images";
mix.copyDirectory(folder.src + "images", out);
mix.copyDirectory(folder.installSrc + "img", out);

let dashboardChosenColor = "#477039";
if (process.env.MIX_DASHBOARD_CHOSEN_COLOR) {
    dashboardChosenColor = "#" + process.env.MIX_DASHBOARD_CHOSEN_COLOR;
} else {
    mix.env(process.env.ENV_FILE);
    dashboardChosenColor = "#" + process.env.MIX_DASHBOARD_CHOSEN_COLOR;
}

mix.js('Modules/Dashboard/Resources/assets/js/backend.js', 'public/js').vue()
    .sass('Modules/Dashboard/Resources/assets/scss/backend.scss', 'public/css', {
        prependData: "$dashboardChosenColor:" + dashboardChosenColor + ";"
    })
    .js('Modules/Installer/Resources/assets/js/installer.js', 'public/js')
    .sass('Modules/Installer/Resources/assets/scss/installer.scss', 'public/css', {
        prependData: "$chosenColor:" + dashboardChosenColor + ";"
    });
// Handle rtl
mix.webpackConfig({
    plugins: [
        new WebpackRTLPlugin({
            diffOnly: false,
            minify: true,
        }),
    ],
    stats: {
        children: false,
    }
});


mix.version([
    'public/js/*',
    'public/css/*',
]);
