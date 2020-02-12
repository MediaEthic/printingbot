import index from "../../components/sales/invoices/index";
import create from "../../components/sales/invoices/create";
import edit from "../../components/sales/invoices/edit";

export default [
    {
        path: '/sales/invoices',
        name: 'invoices.index',
        component: index,
        meta: {
            title: 'Factures - PrintingBot',
            requiresAuth: true
        }
    },
    {
        path: '/sales/invoices/create',
        name: 'invoices.create',
        component: create,
        meta: {
            title: "Création d'une facture - PrintingBot",
            requiresAuth: true
        }
    },
    // {
    //     path: '/sales/invoices/:id/show',
    //     name: 'invoices.show',
    //     component: show,
    //     meta: {
    //         title: "Edition d'une facture - PrintingBot",
    //         requiresAuth: true
    //     }
    // },
    {
        path: '/sales/invoices/:id/edit',
        name: 'invoices.edit',
        component: edit,
        meta: {
            title: "Edition d'une facture - PrintingBot",
            requiresAuth: true
        }
    },
];
