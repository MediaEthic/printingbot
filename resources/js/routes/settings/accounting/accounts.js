import Account from "../../../components/settings/accounting/accounts/index";

export default [
    {
        path: '/settings/accounting/accounts',
        name: 'accounts.index',
        component: Account,
        meta: {
            title: 'Comptes de vente',
            requiresAuth: true
        }
    },
];
