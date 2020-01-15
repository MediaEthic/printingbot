import Supply from "../../../components/settings/production/supplies/index";

export default [
    {
        path: '/settings/production/supplies',
        name: 'supplies.index',
        component: Supply,
        meta: {
            title: 'Travaux de table et fournitures',
            requiresAuth: true
        }
    },
];
