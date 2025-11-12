/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
    require('bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min');
    require('bootstrap-select/dist/js/bootstrap-select.js');
    require('select2/dist/js/select2.full');
} catch (e) {
}
