const { mix } = require('laravel-mix');

mix
    .copy('node_modules/jquery/dist/jquery.slim.min.js', 'public/dist/vendors/jquery.slim.min.js')

    .copy('node_modules/bootstrap/dist/js/bootstrap.min.js', 'public/dist/vendors/bootstrap.min.js')
    .copy('node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/dist/vendors/bootstrap.min.css')
    .copy('node_modules/bootstrap/dist/css/bootstrap.min.css.map', 'public/dist/vendors/bootstrap.min.css.map')

    .copy('node_modules/font-awesome/fonts', 'public/dist/fonts')
    .copy('node_modules/font-awesome/css/font-awesome.min.css', 'public/dist/vendors/font-awesome.min.css')
    .copy('node_modules/font-awesome/css/font-awesome.css.map', 'public/dist/vendors/font-awesome.css.map')

    .copy('node_modules/select2/dist/css/select2.min.css', 'public/dist/vendors/select2.min.css')
    .copy('node_modules/select2/dist/js/select2.min.js', 'public/dist/vendors/select2.min.js')
    .copy('node_modules/select2/dist/js/i18n/pt-BR.js', 'public/dist/vendors/select2-pt-BR.js')

    .copy('node_modules/jquery-mask-plugin/dist/jquery.mask.min.js', 'public/dist/vendors/jquery.mask.min.js')

    .copy('node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css', 'public/dist/vendors/bootstrap-datepicker3.min.css')
    .copy('node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css.map', 'public/dist/vendors/bootstrap-datepicker3.min.css.map')
    .copy('node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', 'public/dist/vendors/bootstrap-datepicker.min.js')
    .copy('node_modules/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pt-BR.min.js', 'public/dist/vendors/bootstrap-datepicker.pt-BR.min.js')

    .sass('resources/assets/sass/form.scss', 'public/dist');


