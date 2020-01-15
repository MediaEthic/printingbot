import Size from "../../../components/settings/product/sizes/index";

export default [
    {
        path: '/settings/product/sizes',
        name: 'sizes.index',
        component: Size,
        meta: {
            title: 'Formats',
            requiresAuth: true
        }
    },
];
