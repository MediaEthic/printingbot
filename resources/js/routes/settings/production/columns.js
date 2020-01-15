import Column from "../../../components/settings/production/columns/index";

export default [
    {
        path: '/settings/production/columns',
        name: 'columns.index',
        component: Column,
        meta: {
            title: 'Rubriques',
            requiresAuth: true
        }
    },
];
