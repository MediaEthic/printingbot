import Company from "../../../components/settings/corporation/companies/index";

export default [
    {
        path: '/settings/corporation/companies',
        name: 'companies.index',
        component: Company,
        meta: {
            title: 'Entreprises',
            requiresAuth: true
        }
    },
];
