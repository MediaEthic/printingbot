import Category from "../../../components/settings/third/categories/index";

export default [
    {
        path: '/settings/third/categories',
        name: 'categories.index',
        component: Category,
        meta: {
            title: "Catégories d'organisation",
            requiresAuth: true
        }
    },
];
