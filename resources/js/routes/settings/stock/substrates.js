import Substrate from "../../../components/settings/stock/substrates/index";

export default [
    {
        path: '/settings/stock/substrates',
        name: 'substrates.index',
        component: Substrate,
        meta: {
            title: "Supports d'impression",
            requiresAuth: true
        }
    },
];
