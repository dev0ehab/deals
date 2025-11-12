import swal from "sweetalert2";
import Vue from 'vue';
import VueInternationalization from 'vue-i18n';
import Locale from '../../../../../resources/js/vue-i18n-locales.generated';
import FileUploader from 'laravel-file-uploader';
import PrettyCheckbox from 'pretty-checkbox-vue';

require('./bootstrap');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

const lang = document.documentElement.lang.substr(0, 2);

window.axios = require('axios');

window.Parsley.setLocale(lang);

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['lang'] = lang;
window.axios.defaults.headers.common['Accept-Language'] = lang;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Accept-Language': lang,
        'Lang': lang
    }
});

const langMap = {
    ar: "ar_AR",
    en: "en_US",
};

if (lang in langMap) {
    require("bootstrap-select/js/i18n/defaults-" + langMap[lang]);
} else {
    console.error("Unknown language " + document.documentElement.lang);
}

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

Vue.use(PrettyCheckbox);

Vue.use(FileUploader);

Vue.use(VueInternationalization);

const toast = swal.mixin();
window.toast = toast;

// Vue.use(VueSweetalert2);

// or however you determine your current app locale

const i18n = new VueInternationalization({
    locale: lang,
    messages: Locale
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('select2', require('./components/Select2Component').default);

const backend = new Vue({
    el: '#vue',
    i18n
});

