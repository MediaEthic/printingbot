import Supplier from "../../../components/settings/third/suppliers/index";

export default [
    {
        path: '/settings/third/suppliers',
        name: 'suppliers.index',
        component: Supplier,
        meta: {
            title: 'Fournisseurs',
            requiresAuth: true
        }
    },
];
