var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .autoProvidejQuery()
    .autoProvideVariables({
        "window.Bloodhound": require.resolve('bloodhound-js'),
        "jQuery.tagsinput": "bootstrap-tagsinput"
    })
    .enableSassLoader()
    .enableVersioning()
    .createSharedEntry('js/common', [ 'jquery' ])
    .addEntry('js/app', './assets/js/app.js')
    .addEntry('js/login', './assets/js/login.js')
    .addEntry('js/admin', './assets/js/admin.js')
    .addEntry('js/jb_main', './assets/js/main.js')
    .addEntry('js/search', './assets/js/search.js')
    .addStyleEntry('css/app', [ './assets/scss/app.scss' ])
    .addStyleEntry('css/admin', [ './assets/scss/admin.scss' ])
    .addStyleEntry('css/jb_style', [ './assets/scss/jb_style.scss' ])
;

const configDev = Encore.getWebpackConfig();
configDev.name = 'configDev';
Encore.reset();

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/gestion-projet/public/build')
    .setManifestKeyPrefix('build/')
    .cleanupOutputBeforeBuild()
    .autoProvidejQuery()
    .autoProvideVariables({
        "window.Bloodhound": require.resolve('bloodhound-js'),
        "jQuery.tagsinput": "bootstrap-tagsinput"
    })
    .enableSassLoader()
    .enableVersioning()
    .createSharedEntry('js/common', [ 'jquery' ])
    .addEntry('js/app', './assets/js/app.js')
    .addEntry('js/login', './assets/js/login.js')
    .addEntry('js/admin', './assets/js/admin.js')
    .addEntry('js/jb_main', './assets/js/main.js')
    .addEntry('js/search', './assets/js/search.js')
    .addStyleEntry('css/app', [ './assets/scss/app.scss' ])
    .addStyleEntry('css/admin', [ './assets/scss/admin.scss' ])
    .addStyleEntry('css/jb_style', [ './assets/scss/jb_style.scss' ])
;

const configProd = Encore.getWebpackConfig();
configProd.name = 'configProd';
Encore.reset();

// export the final configuration as an array of multiple configurations
module.exports = [ configDev, configProd ];