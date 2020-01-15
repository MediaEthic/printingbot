import Statistic from "../../components/statistics/index";

export default [
    {
        path: '/statistics',
        name: 'statistics.index',
        component: Statistic,
        meta: {
            title: 'Statistiques',
            requiresAuth: true
        }
    },
];
