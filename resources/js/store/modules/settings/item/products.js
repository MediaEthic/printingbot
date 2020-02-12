import axios from 'axios';

const state = {
    products: [],
    filteredProducts: [],
};

const getters = {
    allProducts(state) {
        console.log("state.products");
        console.log(state.products);
        return state.products;
    },
    filteredProducts(state) {
        return state.filteredProducts;
    },
};

const actions = {
    async fetchProducts(context, credentials) {
        let pagination = "";
        if (credentials && credentials.pagination) {
            pagination = "/" + credentials.pagination;
        }
        let data = (await axios.get('/api/auth/settings/item/products' + pagination)).data;  // products.index
        console.log("fetchProducts");
        console.log(data);
        context.commit('setProducts', data);
    },
    async searchProducts(context, credentials) {
        let query = "";
        if (credentials && credentials.query) {
            query = credentials.query;
        }

        let data = (await axios.post('/api/auth/settings/item/products/search', {
            query: query
        })).data;  // products.search
        context.commit('setFilteredProducts', data);
    },
};

const mutations = {
    setProducts(state, products) {
        state.products = products;
    },
    setFilteredProducts(state, products) {
        state.filteredProducts = products;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
