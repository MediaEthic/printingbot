import Type from "../../../components/settings/stock/types/index";

export default [
    {
        path: '/settings/stock/types',
        name: 'types.index',
        component: Type,
        meta: {
            title: 'Types de supports',
            requiresAuth: true
        }
    },
];
