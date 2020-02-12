import axios from 'axios';

const state = {
    vats: [],
};

const getters = {
    allVats(state) {
        return state.vats;
    },
};

const actions = {
    async fetchVats(context, credentials) {
        let data = (await axios.get(credentials.url)).data;
        context.commit('setVats', data);
    },
};

const mutations = {
    setVats(state, vats) {
        state.vats = vats;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
