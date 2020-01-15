import Delivery from "../../components/sales/deliveries/index";

export default [
    {
        path: '/sales/deliveries',
        name: 'deliveries.index',
        component: Delivery,
        meta: {
            title: 'Bons de livraison',
            requiresAuth: true
        }
    },
];
