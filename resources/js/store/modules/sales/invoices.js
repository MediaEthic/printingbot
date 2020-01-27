import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

const state = {
    invoices: [],
    form: {
        header: {
            type: "invoice",
            name: "",
            invoice_no: "",
            invoice_date: "",
            invoice_status: "draft",
            third_type: "",
            third_id: "",
            third_alias: "",
            third_name: "",
            third_address_line1: "",
            third_address_line2: "",
            third_address_line3: "",
            third_zipcode: "",
            third_city: "",
            third_country: "",
            third_intracommunity_no: "",
            third_reference: "",
            user_id: "",
            user_commission_base: "",
            user_commission_rate: "",
            user_commission_amount: "",
            discount_rate: "",
            bank_rate: "",
            discount_duration: "",
            payment_id: "",
            settlement_id: "",
            due_date: "",
            subtotal: "",
            vat: "",
            total: "",
        },
        body: {
            lines: []
        }
    }
};

const getters = {
    allInvoices(state) {
        return state.invoices;
    },
    formInvoice(state) {
        return state.form;
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
