import axios from 'axios';

const state = {
    vats: [],
};

const getters = {
    allVats(state) {
        return state.vats;
    },
};

const mutations = {
    setVats(state, vats) {
        state.vats = vats;
    },
};

const actions = {
    async fetchVats(context, credentials) {
        let data = (await axios.get(credentials.url)).data;
        context.commit('setVats', data);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
