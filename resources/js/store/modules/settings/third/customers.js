import axios from 'axios';

const state = {
    customers: [],
};

const mutations = {
    // setProducts(state, products) {
    //     state.products = products;
    // },
};

const getters = {
    allProducts(state) {
        console.log("state.products");
        console.log(state.products);
        return state.products;
    },
};

const actions = {
    // async fetchProducts(context, credentials) {
    //     let pagination = "";
    //     if (credentials && credentials.pagination) {
    //         pagination = "/" + credentials.pagination;
    //     }
    //     let data = (await axios.get('/api/auth/settings/item/products' + pagination)).data;  // products.index
    //     console.log("fetchProducts");
    //     console.log(data);
    //     context.commit('setProducts', data);
    // },
    async search(context, credentials) {
        let query = "";
        if (credentials && credentials.queryString) {
            query = credentials.queryString;
        }

        return new Promise((resolve, reject) => {
            axios.post('/api/auth/settings/third/customers/search', {
                query: query
            }).then(response => {
                resolve(response.data.data);
            }).catch(error => {
                reject(error);
            });  // customers.search
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
