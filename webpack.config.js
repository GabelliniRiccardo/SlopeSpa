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

  .copyFiles({
    from: './assets/images',

    // optional target path, relative to the output dir
    //to: 'images/[path][name].[ext]',
    // if versioning is enabled, add the file hash too
    to: 'images/[name].[ext]',

    // only copy files matching this pattern
    //pattern: /\.(png|jpg|jpeg)$/
  })

  .copyFiles({
    from: './assets/json',
    to: 'json/[name].[ext]',
  })

  .addEntry('js/app', [
    './assets/js/app.js',
  ])

  .addEntry('js/loadParticles', [
    './node_modules/particles.js/particles.js',
    './assets/js/loadParticles.js',
  ])

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
    './node_modules/bootstrap-auto-dismiss-alert',
  ])

  .addEntry('js/charts', [
    './node_modules/chart.js/dist/Chart.bundle.js',
    './node_modules/chart.js/dist/Chart.js',
    './node_modules/randomcolor/randomColor.js',
  ])

  .addEntry('js/reservation-histogram-chart', [
    './assets/js/reservation-histogram-chart.js'
  ])

  .addEntry('js/reservation-line-chart', [
    './assets/js/reservation-line-chart.js'
  ])

  .addEntry('js/treatment-histogram-chart', [
    './assets/js/treatment-histogram-chart.js'
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

  .addEntry('js/delete-Customer', [
    './assets/js/delete-Customer.js'
  ])

  .addEntry('js/delete-reservation', [
    './assets/js/delete-reservation.js'
  ])

  .addEntry('js/edit-reservation', [
    './assets/js/edit-reservation.js'
  ])

  .addEntry('js/create-reservation', [
    './assets/js/create-reservation.js'
  ])

  .addStyleEntry('css/particles', [
    './assets/css/particles.css',
  ])

  .addStyleEntry('css/charts', [
    './node_modules/chart.js/dist/Chart.css',
  ])

  .addStyleEntry('css/sb-admin-2', [
    './node_modules/startbootstrap-sb-admin-2/css/sb-admin-2.css',
    './node_modules/@fortawesome/fontawesome-free/css/all.css',
  ])

  .addStyleEntry('css/one-page-wonder', [
    './node_modules/startbootstrap-one-page-wonder/vendor/bootstrap/css/bootstrap.min.css',
    './node_modules/startbootstrap-one-page-wonder/css/one-page-wonder.css',
  ])

  .addStyleEntry('css/signin', ['./assets/css/signin.css'])

  .addStyleEntry('css/fullcalendar', [
    './node_modules/@fullcalendar/core/main.css',
    './node_modules/@fullcalendar/timeline/main.css',
    './node_modules/@fullcalendar/resource-timeline/main.css',
    './node_modules/@fullcalendar/timegrid/main.css',
    './node_modules/@fullcalendar/bootstrap/main.css',
    './assets/css/my-custom-calendar.css'
  ])

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

  // Enable Vue.js
  .enableVueLoader()

  // uncomment if you're having problems with a jQuery plugin
  .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
