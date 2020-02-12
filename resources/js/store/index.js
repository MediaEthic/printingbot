import Vue from 'vue';
import Vuex from 'vuex';
import users from './modules/settings/company/users';
import payments from './modules/settings/accounting/payments';
import settlements from './modules/settings/accounting/settlements';
import vats from './modules/settings/accounting/vats';
import customers from './modules/settings/third/customers';
import products from './modules/settings/item/products';
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
        users,

        payments,
        settlements,
        vats,

        customers,

        products,

        invoices,
    },
    strict: debug,
});
