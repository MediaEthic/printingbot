import Item from "../../../components/settings/product/items/index";

export default [
    {
        path: '/settings/product/items',
        name: 'items.index',
        component: Item,
        meta: {
            title: 'Articles prédéfinis',
            requiresAuth: true
        }
    },
];
