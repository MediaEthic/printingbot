import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

const state = {
    invoices: [],
};

const getters = {
    allInvoices(state) {
        return state.invoices;
    },
};

const actions = {
    async fetchInvoices(context, credentials) {
        console.log(credentials.filters);
        let data = (await axios.post(credentials.url, { // invoices.index
            filters: credentials.filters
        })).data;
        context.commit('setInvoices', data);
    },
    generatePDF(context, credentials) {
        console.log("generatePDF");
        console.log("credentials.invoicesID");
        console.log(credentials.invoicesID);
        return new Promise((resolve, reject) => {
            axios.post('/api/auth/sales/invoices/pdf', { // invoices.generatePDF
                invoices: credentials.invoicesID
            }).then(response => {
                console.log(response);
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
        console.log(data);
    },
    searchCustomersForAutocomplete(context, credentials) {
        return new Promise((resolve, reject) => {
            axios.post('/api/auth/sales/invoices/customers/search', {
                queryString: credentials.queryString
            }).then(response => {
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
    }
};

const mutations = {
    setInvoices(state, invoices) {
        state.invoices = invoices;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
