import Payment from "../../../components/settings/accounting/payments/index";

export default [
    {
        path: '/settings/accounting/payments',
        name: 'payments.index',
        component: Payment,
        meta: {
            title: 'Modes de règlement',
            requiresAuth: true
        }
    },
];
