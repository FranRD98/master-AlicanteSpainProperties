// Ejecutar para eliminar warning
// npm install autoprefixer@10.4.5 --save-exact

let mix = require('laravel-mix');

// Opciones
mix.options({
    processCssUrls: false
});

mix.setPublicPath('./');
mix.setResourceRoot('./');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 */

// Front CSS
mix.sass('css/source/website.scss', 'css/website.css');

// Front JS Plugins
mix.scripts([
    'js/source/jquery.validate.min.js',
    'js/source/bootstrap/bootstrap.bundle.js',
    'js/source/jquery.bootstrap-dropdown-hover.js',
    'js/source/jquery.customSelect.js',
    'js/source/moment-with-locales.js',
    'js/source/slick/slick.js',
    'js/source/swipebox/src/js/jquery.swipebox.js',
    'js/source/OpenStreetMap/leaflet.js',
    'js/source/OpenStreetMap/leaflet.markercluster.js',
    'js/source/sidr/dist/jquery.sidr.js',
    'js/source/sweetalert/sweetalert.min.js',
    'js/source/jquery.ihavecookies.js',
    'js/source/precios.js'
], 'js/plugins.js');

// Front JS
mix.babel('js/source/website.js', 'js/website.js');

// Redactor
mix.sass('intramedianet/includes/assets/_custom/vendor/redactor/scss/redactor.scss', 'intramedianet/includes/assets/_custom/vendor/redactor/redactor.css');

// Admin CSS
mix.sass('intramedianet/includes/assets/scss/config/default/app.scss', 'intramedianet/includes/assets/css/app.min.css');
mix.sass('intramedianet/includes/assets/_custom/custom.scss', 'intramedianet/includes/assets/css/custom.min.css');

mix.sass('intramedianet/includes/assets/scss/config/default/app-letsinmo.scss', 'intramedianet/includes/assets/css/app-letsinmo.min.css');
mix.sass('intramedianet/includes/assets/_custom/custom-letsinmo.scss', 'intramedianet/includes/assets/css/custom-letsinmo.min.css');

// Admin Fonts
mix.copyDirectory('node_modules/@fortawesome/fontawesome-pro/webfonts/*', 'intramedianet/includes/assets/fonts');

// Admin JS
// mix.scripts([
//     'intramedianet/includes/assets/vendor/js/app.js'
// ], 'intramedianet/includes/assets/js/app.js');

// Admin JS Plugins
// mix.scripts([
//     'intramedianet/includes/assets/vendor/bower_components/bootstrap/js/transition.js',
//     'intramedianet/includes/assets/vendor/bower_components/bootstrap/js/alert.js',
//     'intramedianet/includes/assets/vendor/bower_components/bootstrap/js/button.js',
//     'intramedianet/includes/assets/vendor/bower_components/bootstrap/js/collapse.js',
//     'intramedianet/includes/assets/vendor/bower_components/bootstrap/js/dropdown.js',
//     'intramedianet/includes/assets/vendor/bower_components/bootstrap/js/modal.js',
//     'intramedianet/includes/assets/vendor/bower_components/bootstrap/js/tooltip.js',
//     'intramedianet/includes/assets/vendor/bower_components/bootstrap/js/popover.js',
//     'intramedianet/includes/assets/vendor/bower_components/bootstrap/js/tab.js',
//     'intramedianet/includes/assets/vendor/bower_components/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js',
//     'intramedianet/includes/assets/vendor/bower_components/datatables/media/js/jquery.dataTables.js',
//     'intramedianet/includes/assets/vendor/components/datatables-bootstrap-3/dataTables.checkboxes.js',
//     'intramedianet/includes/assets/vendor/components/datatables-bootstrap-3/jquery.dataTables.bootstrap.js',
//     'intramedianet/includes/assets/vendor/components/redactor/redactor.js',
//     'intramedianet/includes/assets/vendor/components/redactor/plugins/fullscreen/fullscreen.js',
//     'intramedianet/includes/assets/vendor/components/redactor/plugins/fontcolor/fontcolor.js',
//     'intramedianet/includes/assets/vendor/components/redactor/plugins/fontsize/fontsize.js',
//     'intramedianet/includes/assets/vendor/components/redactor/plugins/table/table.js',
//     'intramedianet/includes/assets/vendor/components/redactor/plugins/video/video.js',
//     'intramedianet/includes/assets/vendor/components/redactor/plugins/source/source.js',
//     'intramedianet/includes/assets/vendor/components/redactor/plugins/alignment/alignment.js',
//     'intramedianet/includes/assets/vendor/components/redactor/plugins/counter/counter.js',
//     'intramedianet/includes/assets/vendor/bower_components/pwstrength-bootstrap/dist/pwstrength-bootstrap-1.2.5.js',
//     'intramedianet/includes/assets/vendor/bower_components/jquery-validation/dist/jquery.validate.js',
//     'intramedianet/includes/assets/vendor/bower_components/jquery-validation/dist/additional-methods.js',
//     'intramedianet/includes/assets/vendor/components/jQuery-Gravatar-master/md5.js',
//     'intramedianet/includes/assets/vendor/components/jQuery-Gravatar-master/jquery.gravatar.js',
//     'intramedianet/includes/assets/vendor/components/jquery.sparkline/jquery.sparkline.js',
//     'intramedianet/includes/assets/vendor/components/jquery-ui-1.11.3.custom/jquery-ui.js',
//     'intramedianet/includes/assets/vendor/bower_components/jqueryui-touch-punch/jquery.ui.touch-punch.js',
//     'intramedianet/includes/assets/vendor/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js',
//     'intramedianet/includes/assets/vendor/bower_components/select2/select2.js',
//     'intramedianet/includes/assets/vendor/bower_components/Nestable/jquery.nestable.js',
//     'intramedianet/includes/assets/vendor/bower_components/moment/moment.js',
//     'intramedianet/includes/assets/vendor/bower_components/fullcalendar/dist/fullcalendar.js',
//     'intramedianet/includes/assets/vendor/bower_components/datetimepicker/build/jquery.datetimepicker.full.js',
//     'intramedianet/includes/assets/vendor/bower_components/jquery-minicolors/jquery.minicolors.js',
//     'intramedianet/includes/assets/vendor/bower_components/ion.rangeSlider/js/ion.rangeSlider.js',
//     'intramedianet/includes/assets/vendor/bower_components/datatables-colvis/js/dataTables.colVis.js',
//     'intramedianet/includes/assets/vendor/bower_components/bootstrap-rating-input/src/bootstrap-rating-input.js',
//     'intramedianet/includes/assets/vendor/bower_components/ekko-lightbox/dist/ekko-lightbox.js',
//     'intramedianet/includes/assets/vendor/bower_components/jquery.cookie/jquery.cookie.js',
//     'intramedianet/includes/assets/vendor/bower_components/flot/jquery.flot.js',
//     'intramedianet/includes/assets/vendor/bower_components/flot/jquery.flot.pie.js',
//     'intramedianet/includes/assets/vendor/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js',
//     'intramedianet/includes/assets/vendor/bower_components/zeroclipboard/dist/ZeroClipboard.js',
//     'intramedianet/includes/assets/vendor/bower_components/plupload/js/plupload.full.min.js',
//     'intramedianet/includes/assets/vendor/bower_components/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js',
//     'intramedianet/includes/assets/vendor/components/jQuery-Text-Counter/textcounter.js',
//     'intramedianet/includes/assets/vendor/bower_components/switchery/dist/switchery.js'
// ], 'intramedianet/includes/assets/js/plugins.js');

// mix.sourceMaps();
// mix.version();

// BrowserSync
mix.browserSync({
    proxy: {
        target: "https://master.test",
    },
    https: true,
    files: ['**/*.tpl', '**/*.css', '**/*.js', '**/*.php', '!**/*.tpl.php', '!js/source/**/*.js']
});
