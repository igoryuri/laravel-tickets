
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../bootstrap');

window.Vue = require('vue');


var moment = require('moment'); // locales all in lower-case

moment.locale('pt-br');
exports.install = function (Vue, options) {
    Vue.prototype.moment = function (args) {
        return moment(args);
    };
}

Vue.use(exports);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('monitoring', require('./components/monitoring.vue'));

const app = new Vue({
    el: '#app'
});
