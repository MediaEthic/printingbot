import Family from "../../../components/settings/stock/families/index";

export default [
    {
        path: '/settings/stock/families',
        name: 'families.index',
        component: Family,
        meta: {
            title: 'Familles de supports',
            requiresAuth: true
        }
    },
];
