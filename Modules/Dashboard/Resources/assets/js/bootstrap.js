window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
    require('bootstrap-select/dist/js/bootstrap-select.js');
    require('summernote/dist/summernote.js');
    require('select2/dist/js/select2.full');
    require('jquery.repeater/jquery.repeater');
    require('dropify/dist/js/dropify')
    window.dragula = require('dragula/dist/dragula');
    require('parsleyjs');
    require('parsleyjs/src/i18n/ar');
    require('parsleyjs/src/i18n/en');
    require('parsleyjs/src/i18n/tr');
    require('metismenu');
    require('simplebar');
    require('node-waves');
    require('./config');
    require('./editor');
    require('./laravelMediaUploaderValidator');
    require('./custom');
    require('./formValidation');
    import('./mapInput');
    require('./repeater');
    require('./notify.min.js');
} catch (e) {
}
