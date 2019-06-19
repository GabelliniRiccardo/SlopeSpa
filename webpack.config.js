var Encore = require('@symfony/webpack-encore');

Encore
// directory where compiled assets will be stored
  .setOutputPath('public/build/')
  // public path used by the web server to access the output path
  .setPublicPath('/build')
  // only needed for CDN's or sub-directory deploy
  //.setManifestKeyPrefix('build/')

  /*
   * ENTRY CONFIG
   *
   * Add 1 entry for each "page" of your app
   * (including one that's included on every page - e.g. "app")
   *
   * Each entry will result in one JavaScript file (e.g. app.js)
   * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
   */
  .addEntry('js/loadJQuery', [
    './assets/js/loadJQuery.js'
  ])

  .addEntry('js/sb-admin-2.min', [
    './assets/js/sb-admin-2.min.js'
  ])

  .addEntry('vendor', [ // Will be processed by CommonsChunkPlugin
    'popper.js',
    'bootstrap',
    '@fortawesome/fontawesome-free/js/all.js',
  ])

  .addStyleEntry('style.vendor', [
    './node_modules/bootstrap/scss/bootstrap.scss',
    './node_modules/@fortawesome/fontawesome-free/css/all.css',
  ])

  .addStyleEntry('css/signin', ['./assets/css/signin.css'])

  .addStyleEntry('css/sb-admin-2', ['./assets/css/sb-admin-2.min.css'])

  // will require an extra script tag for runtime.js
  // but, you probably want this, unless you're building a single-page app
  .disableSingleRuntimeChunk()

  .cleanupOutputBeforeBuild()
  .enableSourceMaps(!Encore.isProduction())
  // enables hashed filenames (e.g. app.abc123.css)
  .enableVersioning(Encore.isProduction())

// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment if you use Sass/SCSS files
.enableSassLoader()

// uncomment if you're having problems with a jQuery plugin
// .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
