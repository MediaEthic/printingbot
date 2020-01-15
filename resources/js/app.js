import Vue from 'vue';
import router from './router';
import store from './store';
import App from './components/app';

require('./bootstrap');

const app = new Vue({
    el: '#app',
    components: {
        App
    },
    store,
    router
});
