import Dispatch from "../../../components/settings/production/dispatches/index";

export default [
    {
        path: '/settings/production/dispatches',
        name: 'dispatches.index',
        component: Dispatch,
        meta: {
            title: "Modes d'expédition",
            requiresAuth: true
        }
    },
];
