import Vue from 'vue';
import Vuex from 'vuex';
import invoices from './modules/sales/invoices';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    state: {
    },
    mutations: {
    },
    actions: {
    },
    modules: {
        invoices,
    },
    strict: debug,
});
