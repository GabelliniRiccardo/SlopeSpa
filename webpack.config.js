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

  .addEntry('js/one-page-wonder', [
    './node_modules/startbootstrap-one-page-wonder/vendor/jquery/jquery.min.js',
    './node_modules/startbootstrap-one-page-wonder/vendor/bootstrap/js/bootstrap.min.js',
    './node_modules/startbootstrap-one-page-wonder/vendor/bootstrap/js/bootstrap.bundle.min.js',
  ])

  .addEntry('js/sb-admin-2', [
    './node_modules/startbootstrap-sb-admin-2/vendor/jquery/jquery.min.js',
    './node_modules/startbootstrap-sb-admin-2/vendor/jquery-easing/jquery.easing.min.js',
    './node_modules/startbootstrap-sb-admin-2/vendor/bootstrap/js/bootstrap.js',
    './node_modules/startbootstrap-sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min.js',
    './node_modules/startbootstrap-sb-admin-2/js/sb-admin-2.js',
    '@fortawesome/fontawesome-free/js/all.js',
  ])

  .addEntry('js/delete-SPA', [
    './assets/js/delete-SPA.js'
  ])

  .addEntry('js/delete-User', [
    './assets/js/delete-User.js'
  ])

  .addEntry('js/delete-Operator', [
    './assets/js/delete-Operator.js'
  ])

  .addEntry('js/delete-Treatment', [
    './assets/js/delete-Treatment.js'
  ])

  .addEntry('js/delete-Room', [
    './assets/js/delete-Room.js'
  ])

  .addStyleEntry('css/sb-admin-2', [
    './node_modules/startbootstrap-sb-admin-2/css/sb-admin-2.css',
    './node_modules/@fortawesome/fontawesome-free/css/all.css',
  ])

  .addStyleEntry('css/one-page-wonder', [
    './node_modules/startbootstrap-one-page-wonder/vendor/bootstrap/css/bootstrap.min.css',
    './node_modules/startbootstrap-one-page-wonder/css/one-page-wonder.min.css',
  ])

  .addStyleEntry('css/signin', ['./assets/css/signin.css'])

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
.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
