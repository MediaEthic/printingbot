import axios from 'axios';
import {getField, updateField} from "vuex-map-fields";

const state = {
    customers: [],
};

const getters = {
    allCustomers(state) {
        return state.customers;
    },
    line(state) {
        return state.line;
    },
};

const mutations = {
    SET_CUSTOMERS(state, customers) {
        state.customers = customers;
    },
};

const actions = {
    async paginate({ commit }, credentials) {
        let data = (await axios.post(credentials.url, { // customers.paginate
            filters: credentials.filters
        })).data;
        commit('SET_CUSTOMERS', data);
    },
    async search(context, credentials) {
        let query = "";
        if (credentials && credentials.queryString) {
            query = credentials.queryString;
        }

        return new Promise((resolve, reject) => {
            axios.post('/api/auth/settings/third/customers/search', {
                query: query
            }).then(response => {
                resolve(response.data.data);
            }).catch(error => {
                reject(error);
            });  // customers.search
        });
    },
    async searchContacts(context, credentials) {
        let query = "";
        if (credentials && credentials.queryString) {
            query = credentials.queryString;
        }

        return new Promise((resolve, reject) => {
            axios.post('/api/auth/settings/third/customers/contacts/search', {
                query: query
            }).then(response => {
                resolve(response.data.data);
            }).catch(error => {
                reject(error);
            });  // customers.search
        });
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
