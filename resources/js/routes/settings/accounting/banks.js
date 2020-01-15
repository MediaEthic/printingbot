import Bank from "../../../components/settings/accounting/banks/index";

export default  [
    {
        path: '/settings/accounting//banks',
        name: 'banks.index',
        component: Bank,
        meta: {
            title: 'Banques',
            requiresAuth: true
        }
    },
];
