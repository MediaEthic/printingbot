import Vat from "../../../components/settings/accounting/vats/index";

export default [
    {
        path: '/settings/accounting//vats',
        name: 'vats.index',
        component: Vat,
        meta: {
            title: 'Taux de TVA',
            requiresAuth: true
        }
    },
];
