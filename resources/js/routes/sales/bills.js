import Bill from "../../components/sales/bills/index";

export default [
    {
        path: '/sales/bills',
        name: 'bills.index',
        component: Bill,
        meta: {
            title: 'Factures',
            requiresAuth: true
        }
    },
];
