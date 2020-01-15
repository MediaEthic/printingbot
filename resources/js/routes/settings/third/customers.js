import Customer from "../../../components/settings/third/customers/index";

export default [
    {
        path: '/settings/third/customers',
        name: 'customers.index',
        component: Customer,
        meta: {
            title: 'Clients',
            requiresAuth: true
        }
    },
];
