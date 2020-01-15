import Finishing from "../../../components/settings/production/finishings/index";

export default [
    {
        path: '/settings/production/finishings',
        name: 'finishings.index',
        component: Finishing,
        meta: {
            title: 'Finitions',
            requiresAuth: true
        }
    },
];
