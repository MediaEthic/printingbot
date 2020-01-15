import Establishment from "../../../components/settings/corporation/establishments/index";

export default [
    {
        path: '/settings/corporation/establishments',
        name: 'establishments.index',
        component: Establishment,
        meta: {
            title: 'Etablissements',
            requiresAuth: true
        }
    },
];
