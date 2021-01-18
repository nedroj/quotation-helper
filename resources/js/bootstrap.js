/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window._ = require('lodash');

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': token.content } });
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Setup Vue
 */
import Vue from 'vue/dist/vue.esm';
import VModal from 'vue-js-modal';
import SortedTablePlugin from "vue-sorted-table";

Vue.use(VModal, { dynamic: true, injectModalsContainer: true }, SortedTablePlugin, {
    ascIcon: '<i class="material-icons">arrow_drop_up</i>',
    descIcon: '<i class="material-icons">arrow_drop_down</i>'
});
import VueFlashMessage from 'vue-flash-message';
Vue.use(VueFlashMessage);

import EpicsComponent from "./components/EpicsComponent";
import TaskComponent from "./components/TaskComponent";
import EstimateComponent from "./components/EstimateComponent";
import SelecterEpicComponent from "./components/SelecterEpicComponent";
import SelecterTaskComponenet from "./components/SelecterTaskComponent";
import SelectedEventsComponent from "./components/SelectedEventsComponent";


const app = new Vue({
    name: "App",
    components: {
        EpicsComponent,
        TaskComponent,
        EstimateComponent,
        SelecterEpicComponent,
        SelecterTaskComponenet,
        SelectedEventsComponent,
    },
    data(){
        return {
            csrfToken: $('meta[name="csrf-token"]').attr('content'),
            retrieveEpic:{
                type: Object,
            },
            estimate:{
                type: Object,
            },
            minutes:{
                type: Object,
            },
            time:{
                type: Object,
            }
        }
    },
    methods:{
        updateEpic(variable) {
            this.retrieveEpic = variable;
        },
    }
});

if (document.getElementById('example-component')) {
    app.$mount('#example-component');
}
