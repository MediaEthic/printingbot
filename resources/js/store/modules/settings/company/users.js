import axios from 'axios';

const state = {
    users: [],
};

const getters = {
    allUsers(state) {
        return state.users;
    },
    salespersons: state => {
        return state.users.filter(user => user.trade);
    },
};


const mutations = {
    setUsers(state, users) {
        state.users = users;
    },
};

const actions = {
    async fetchUsers(context, credentials) {
        let data = (await axios.get(credentials.url)).data;
        context.commit('setUsers', data);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
