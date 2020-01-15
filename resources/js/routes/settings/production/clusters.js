import Cluster from "../../../components/settings/production/clusters/index";

export default [
    {
        path: '/settings/production/clusters',
        name: 'clusters.index',
        component: Cluster,
        meta: {
            title: 'Pôles de travail',
            requiresAuth: true
        }
    },
];
