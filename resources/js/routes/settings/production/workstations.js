import Workstation from "../../../components/settings/production/workstations/index";

export default [
    {
        path: '/settings/production/workstations',
        name: 'workstations.index',
        component: Workstation,
        meta: {
            title: 'Postes de production',
            requiresAuth: true
        }
    },
];
