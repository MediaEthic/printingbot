import Bill from "../../components/sales/bills/index";

const routes = [
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

export default routes;
