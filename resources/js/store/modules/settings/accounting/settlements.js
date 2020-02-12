import axios from 'axios';

const state = {
    settlements: [],
};

const getters = {
    allSettlements(state) {
        return state.settlements;
    },
};

const actions = {
    async fetchSettlements(context, credentials) {
        let data = (await axios.get(credentials.url)).data;
        context.commit('setSettlements', data);
    },
};

const mutations = {
    setSettlements(state, settlements) {
        state.settlements = settlements;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
