import User from "../../../components/settings/corporation/users/index";

export default [
    {
        path: '/settings/corporation/users',
        name: 'users.index',
        component: User,
        meta: {
            title: 'Utilisateurs',
            requiresAuth: true
        }
    },
];
