import Vue from 'vue';
import VueRouter from 'vue-router';
import Dashboard from './components/dashboard';

import companiesRoutes from "./routes/settings/corporation/companies";
import establishmentsRoutes from "./routes/settings/corporation/establishments";
import usersRoutes from "./routes/settings/corporation/users";

import banksRoutes from "./routes/settings/accounting/banks";
import vatsRoutes from "./routes/settings/accounting/vats";
import paymentsRoutes from "./routes/settings/accounting/payments";
import conditionsRoutes from "./routes/settings/accounting/conditions";
import accountsRoutes from "./routes/settings/accounting/accounts";

import territoriesRoutes from "./routes/settings/third/territories";
import categoriesRoutes from "./routes/settings/third/categories";
import prospectsRoutes from "./routes/settings/third/prospects";
import customersRoutes from "./routes/settings/third/customers";
import suppliersRoutes from "./routes/settings/third/suppliers";

import finishingsRoutes from "./routes/settings/production/finishings";
import clustersRoutes from "./routes/settings/production/clusters";
import suppliesRoutes from "./routes/settings/production/supplies";
import columnssRoutes from "./routes/settings/production/columns";
import workstationsRoutes from "./routes/settings/production/workstations";
import dispatchesRoutes from "./routes/settings/production/dispatches";

import familiesRoutes from "./routes/settings/stock/families";
import typesRoutes from "./routes/settings/stock/types";
import stiffnessesRoutes from "./routes/settings/stock/stiffnesses";
import substratesRoutes from "./routes/settings/stock/substrates";

import sizesRoutes from "./routes/settings/product/sizes";
import productsRoutes from "./routes/settings/product/products";
import itemsRoutes from "./routes/settings/product/items";

import quotationsRoutes from "./routes/sales/quotations";
import deliveriesRoutes from "./routes/sales/deliveries";
import invoicesRoutes from "./routes/sales/invoices";

import statisticsRoutes from "./routes/statistics/statistics";

Vue.use(VueRouter);

const baseRoutes = [
    {
        path: '/',
        name: 'dashboard.index',
        title: 'Dashboard',
        component: Dashboard,
    },
    {
        path: '*',
        redirect: { name: 'dashboard.index' },
    },
];


export default new VueRouter({
    routes: [
        ...baseRoutes,
        ...companiesRoutes,
        ...establishmentsRoutes,
        ...usersRoutes,

        ...banksRoutes,
        ...vatsRoutes,
        ...paymentsRoutes,
        ...conditionsRoutes,
        ...accountsRoutes,

        ...territoriesRoutes,
        ...categoriesRoutes,
        ...prospectsRoutes,
        ...customersRoutes,
        ...suppliersRoutes,

        ...finishingsRoutes,
        ...clustersRoutes,
        ...suppliesRoutes,
        ...columnssRoutes,
        ...workstationsRoutes,
        ...dispatchesRoutes,

        ...familiesRoutes,
        ...typesRoutes,
        ...stiffnessesRoutes,
        ...substratesRoutes,

        ...sizesRoutes,
        ...productsRoutes,
        ...itemsRoutes,

        ...quotationsRoutes,
        ...deliveriesRoutes,
        ...invoicesRoutes,

        ...statisticsRoutes,
    ],
    mode: 'history',
});
