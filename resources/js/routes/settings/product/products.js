import Product from "../../../components/settings/product/products/index";

export default [
    {
        path: '/settings/product/products',
        name: 'products.index',
        component: Product,
        meta: {
            title: 'Produits imprimés',
            requiresAuth: true
        }
    },
];
