import Stiffness from "../../../components/settings/stock/stiffnesses/index";

export default [
    {
        path: '/settings/stock/stiffnesses',
        name: 'stiffnesses.index',
        component: Stiffness,
        meta: {
            title: 'Rigidité de supports',
            requiresAuth: true
        }
    },
];
