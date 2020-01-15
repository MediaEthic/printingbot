import Condition from "../../../components/settings/accounting/conditions/index";

export default [
    {
        path: '/settings/accounting/conditions',
        name: 'conditions.index',
        component: Condition,
        meta: {
            title: 'Conditions de règlement',
            requiresAuth: true
        }
    },
];
