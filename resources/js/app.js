import 'es6-promise/auto'
import Vue from 'vue';
import router from './router';
import store from './store/index';
import App from './components/app';

import { ValidationObserver, ValidationProvider, extend } from 'vee-validate';
import * as rules from 'vee-validate/dist/rules';
import { localize } from 'vee-validate';
import { messages } from 'vee-validate/dist/locale/fr.json';
import en from 'vee-validate/dist/locale/en.json';
import fr from 'vee-validate/dist/locale/fr.json';

import VModal from 'vue-js-modal';
import VueSweetalert2 from 'vue-sweetalert2';

require('./bootstrap');


// Vee Validate
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);
Object.keys(rules).forEach(rule => {
    extend(rule, {
        ...rules[rule], // copies rule configuration
        message: messages[rule] // assign message
    });
});
localize('fr', fr);


Vue.use(VModal);

const options = {
    confirmButtonColor: '#672767',
    cancelButtonColor: '#E8004C',
};
Vue.use(VueSweetalert2, options);



// Document page title
router.beforeEach((to, from, next) => {
    const nearestWithTitle = to.matched.slice().reverse().find(r => r.meta && r.meta.title);

    const nearestWithMeta = to.matched.slice().reverse().find(r => r.meta && r.meta.metaTags);
    const previousNearestWithMeta = from.matched.slice().reverse().find(r => r.meta && r.meta.metaTags);

    if(nearestWithTitle) document.title = nearestWithTitle.meta.title;

    Array.from(document.querySelectorAll('[data-vue-router-controlled]')).map(el => el.parentNode.removeChild(el));

    if(!nearestWithMeta) return next();

    nearestWithMeta.meta.metaTags.map(tagDef => {
        const tag = document.createElement('meta');

        Object.keys(tagDef).forEach(key => {
            tag.setAttribute(key, tagDef[key]);
        });

        tag.setAttribute('data-vue-router-controlled', '');

        return tag;
    }).forEach(tag => document.head.appendChild(tag));

    next();
});


const app = new Vue({
    el: '#app',
    components: {
        App
    },
    store,
    router
});
