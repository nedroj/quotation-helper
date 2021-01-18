/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */
import route from '../../vendor/tightenco/ziggy/dist/js/route';
window.route = route;

require('./bootstrap');

require('./sidemenu');

require('./loader');

window.Dropzone = require('dropzone');

import Sortable from 'sortablejs';
window.Sortable = Sortable;

require('./functions');

require('vue-flash-message/dist/vue-flash-message.min.css');

require('../../vendor/proengsoft/laravel-jsvalidation/public/js/jsvalidation');

require('./CapsLock');
if ($("#capslockwarning").length > 0) {
    CapsLock.addListener(function (isOn) {
        $("#capslockwarning").toggle(isOn);
    });
}

require('summernote/dist/summernote-bs4');
$(document).ready(function() {
    $('.summernote').summernote({
        height: 400,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
});

require('select2/dist/js/select2.full');
$.fn.select2.defaults.set("theme", "bootstrap4");
$(function() {
    $(".select2").select2();
});
