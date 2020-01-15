import Territory from "../../../components/settings/third/territories/index";

export default [
    {
        path: '/settings/third/territories',
        name: 'territories.index',
        component: Territory,
        meta: {
            title: 'Territoires commerciaux',
            requiresAuth: true
        }
    },
];
