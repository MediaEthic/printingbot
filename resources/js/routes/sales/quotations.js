import Quotation from "../../components/sales/quotations/index";

export default [
    {
        path: '/sales/quotations',
        name: 'quotations.index',
        component: Quotation,
        meta: {
            title: 'Devis/Commandes',
            requiresAuth: true
        }
    },
];
