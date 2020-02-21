import axios from 'axios';

const state = {
    products: [],
    filteredProducts: [],
};

const getters = {
    allProducts(state) {
        return state.products;
    },
    filteredProducts(state) {
        return state.filteredProducts;
    },
};

const mutations = {
    SET_PRODUCTS(state, products) {
        state.products = products;
    },
};

const actions = {
    async paginate({ commit }, credentials) {
        let data = (await axios.post(credentials.url, { // products.paginate
            filters: credentials.filters
        })).data;
        commit('SET_PRODUCTS', data);
    },
    async search(context, credentials) {
        let query = "";
        if (credentials && credentials.queryString) {
            query = credentials.queryString;
        }

        return new Promise((resolve, reject) => {
            axios.post('/api/auth/settings/item/products/search', {
                query: query
            }).then(response => {
                resolve(response.data.data);
            }).catch(error => {
                reject(error);
            });
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
