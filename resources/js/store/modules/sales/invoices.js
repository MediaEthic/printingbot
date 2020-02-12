import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

import { getField, updateField } from 'vuex-map-fields';
import moment from 'moment';


const blankInvoice = {
    id: "",
    invoice_no: "",
    name: "",
    invoice_date: moment().format('YYYY-MM-DD'),
    due_date: moment().format('YYYY-MM-DD'),
    invoice_status: "draft",
    third_id: "",
    third_alias: "",
    third_name: "",
    third_address_line1: "",
    third_address_line2: "",
    third_address_line3: "",
    third_zipcode: "",
    third_city: "",
    third_intracommunity_no: "",
    third_reference: "",
    user_id: "",
    user_commission_base: 0,
    user_commission_rate: "",
    user_commission_amount: "",
    discount_rate: "",
    bank_rate: "",
    discount_duration: "",
    payment_id: "",
    settlement_id: "",
    subtotal: 0,
    discount_amount: 0,
    total_pretax: 0,
    vat: 0,
    total: 0,
};

const state = {
    invoices: [],
    invoice: [blankInvoice],
    lines: []
};

const getters = {
    getField,
    allInvoices(state) {
        return state.invoices;
    },
    line(state) {
        return state.line;
    },
};

const mutations = {
    updateField,
    setInvoices(state, invoices) {
        state.invoices = invoices;
    },
    SET_DUE_DATE : (state, payload) => {
        state.invoice[0].due_date = payload;
    },
    ADD_LINE : (state, payload) => {
        state.lines.push(payload);
    },
    REMOVE_LINE : (state, payload) => {
        state.lines.splice(payload, 1);
    },
    SET_INVOICE: (state, payload) => {
        console.log("SET_INVOICE");
        console.log(payload);
        state.invoice[0] = payload;
    },
    SET_LINES: (state, payload) => {
        console.log("SET_LINES");
        console.log(payload);
        state.lines = payload;
    },
};

const actions = {
    async index({ commit }, credentials) {
        let data = (await axios.post(credentials.url, { // invoices.index
            filters: credentials.filters
        })).data;
        commit('setInvoices', data);
    },
    async editStatus({ commit }, credentials) {
        let data = (await axios.post('/api/auth/sales/invoices/status/edit', { // invoices.index
            invoices: credentials.invoices,
            filters: credentials.filters
        })).data;
        console.log(data);
        commit('setInvoices', data);
    },
    searchCustomersForAutocomplete(context, credentials) {
        return new Promise((resolve, reject) => {
            axios.post('/api/auth/sales/invoices/customers/search', {
                query: credentials.queryString
            }).then(response => {
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
    },
    async create({ commit }) {
        let data = blankInvoice;
        commit('SET_INVOICE', data);
        commit('SET_LINES', []);
    },
    async store({ state, commit }) { // invoices.store
        let data = (await axios.post('/api/auth/sales/invoices', {
            invoice: state.invoice[0],
            lines: state.lines
        })).data;
        commit('SET_INVOICE', data.data);
        commit('SET_LINES', data.data.lines);
    },
    async edit({ commit }, credentials) { // invoices.edit
        let data = (await axios.get('/api/auth/sales/invoices/' + credentials.id + '/edit'));
        console.log("this.invoice");
        console.log(data.data.data);
        commit('SET_INVOICE', data.data.data);
        commit('SET_LINES', data.data.data.lines);
    },
    async update({ state, commit }) { // invoices.update
        console.log("state.invoice[0].id");
        console.log(state.invoice[0].id);
        let data = (await axios.put('/api/auth/sales/invoices/' + state.invoice[0].id, {
            invoice: state.invoice[0],
            lines: state.lines
        })).data;
        console.log(data);
        commit('SET_INVOICE', data.data);
        commit('SET_LINES', data.data.lines);
    },
    async destroyLine(context, credentials) {
        let data = (await axios.delete('/api/auth/sales/invoices/' + credentials.invoice + '/lines/' + credentials.line)).data; // lines.destroy
        context.commit('SET_LINES', data);
    },
};


export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
