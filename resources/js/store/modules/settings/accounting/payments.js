import axios from 'axios';

const state = {
    payments: [],
};

const getters = {
    allPayments(state) {
        return state.payments;
    },
};

const actions = {
    async fetchPayments(context, credentials) {
        let data = (await axios.get(credentials.url)).data;
        context.commit('setPayments', data);
    },
};

const mutations = {
    setPayments(state, payments) {
        state.payments = payments;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
