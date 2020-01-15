import Prospect from "../../../components/settings/third/prospects/index";

export default [
    {
        path: '/settings/third/prospects',
        name: 'prospects.index',
        component: Prospect,
        meta: {
            title: 'Prospects',
            requiresAuth: true
        }
    },
];
