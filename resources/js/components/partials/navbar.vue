<template>
    <nav>
        <ul>
            <li v-for="(route, key) in routes">
                <input class="cd-accordion__input" type="checkbox" :id="'group-' + key"
                       v-if="route.subitems">
                <label class="cd-accordion__label" :for="'group-' + key"
                       v-if="route.subitems">
                    <i :class="route.icon"></i>
                    {{ route.name }}
                </label>

                <ul class="cd-accordion__sub"
                    v-if="route.subitems">
                    <li v-for="(subitem, index) in route.subitems">
                        <input class="cd-accordion__input" type="checkbox" :id="'group-' + key + index"
                               v-if="subitem.subitems">
                        <label class="cd-accordion__label" :for="'group-' + key + index"
                               v-if="subitem.subitems">
                            {{ subitem.name }}
                        </label>

                        <ul class="cd-accordion__sub"
                            v-if="subitem.subitems">
                            <li v-for="(val, pos) in subitem.subitems">
                                <input class="cd-accordion__input" type="checkbox" :id="'group-' + key + index + val">
                                <label class="cd-accordion__label" :for="'group-' + key + index + val">
                                    <router-link :to="{ name: val.path }"
                                                 :key="key + index + val">
                                        {{ val.name }}
                                    </router-link>
                                </label>
                            </li>
                        </ul>

                        <router-link :to="{ name: subitem.path }"
                                     :key="index"
                                     v-else>
                            {{ subitem.name }}
                        </router-link>
                    </li>
                </ul>

                <router-link :to="{ name: route.path }"
                             :key="key"
                             v-else>
                    <i :class="route.icon"></i>
                    {{ route.name }}
                </router-link>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: "Navbar",
        data() {
            return {
                routes: [
                    {
                        name: 'Tableau de bord',
                        path: 'dashboard.index',
                        icon: 'icon-home',
                    },
                    {
                        name: 'Paramètres',
                        icon: 'icon-settings',
                        subitems: [
                            {
                                name: 'Entreprise',
                                subitems: [
                                    {
                                        name: 'Entreprise',
                                        path: 'companies.index',
                                    },
                                    {
                                        name: 'Etablissements',
                                        path: 'establishments.index',
                                    },
                                    {
                                        name: 'Utilisateurs',
                                        path: 'users.index',
                                    },
                                ]
                            },
                            {
                                name: 'Comptabilité',
                                subitems: [
                                    {
                                        name: 'Banques',
                                        path: 'banks.index',
                                    },
                                    {
                                        name: 'Taux de TVA',
                                        path: 'vats.index',
                                    },
                                    {
                                        name: 'Modes de règlement',
                                        path: 'payments.index',
                                    },
                                    {
                                        name: 'Conditions de règlement',
                                        path: 'conditions.index',
                                    },
                                    {
                                        name: 'Comptes de vente',
                                        path: 'accounts.index',
                                    }
                                ]
                            },
                            {
                                name: 'Tiers',
                                subitems: [
                                    {
                                        name: 'Territoires commerciaux',
                                        path: 'territories.index',
                                    },
                                    {
                                        name: "Catégories d'organisation",
                                        path: 'categories.index',
                                    },
                                    {
                                        name: 'Prospects',
                                        path: 'prospects.index',
                                    },
                                    {
                                        name: 'Clients',
                                        path: 'customers.index',
                                    },
                                    {
                                        name: 'Fournisseurs',
                                        path: 'suppliers.index',
                                    }
                                ]
                            },
                            {
                                name: 'Production',
                                subitems: [
                                    {
                                        name: 'Finitions',
                                        path: 'finishings.index',
                                    },
                                    {
                                        name: 'Pôles de travail',
                                        path: 'clusters.index',
                                    },
                                    {
                                        name: 'Travaux de table et fournitures',
                                        path: 'supplies.index',
                                    },
                                    {
                                        name: 'Rubriques',
                                        path: 'columns.index',
                                    },
                                    {
                                        name: 'Postes de production',
                                        path: 'workstations.index',
                                    },
                                    {
                                        name: "Modes d'expédition",
                                        path: 'dispatches.index',
                                    }
                                ]
                            },
                            {
                                name: 'Supports',
                                subitems: [
                                    {
                                        name: 'Familles de supports',
                                        path: 'families.index',
                                    },
                                    {
                                        name: 'Types de supports',
                                        path: 'types.index',
                                    },
                                    {
                                        name: 'Rigidité de supports',
                                        path: 'stiffnesses.index',
                                    },
                                    {
                                        name: "Supports d'impression",
                                        path: 'substrates.index',
                                    },
                                ]
                            },
                            {
                                name: 'Articles',
                                subitems: [
                                    {
                                        name: 'Formats finies et ouverts',
                                        path: 'sizes.index',
                                    },
                                    {
                                        name: 'Produits imprimés',
                                        path: 'products.index',
                                    },
                                    {
                                        name: 'Articles prédéfinis',
                                        path: 'items.index',
                                    },
                                ]
                            },
                        ]
                    },
                    {
                        name: 'Ventes',
                        icon: 'icon-shopping-cart',
                        subitems: [
                            {
                                name: 'Devis/Commandes',
                                path: 'quotations.index',
                            },
                            {
                                name: 'Bons de livraison',
                                path: 'deliveries.index',
                            },
                            {
                                name: 'Factures',
                                path: 'bills.index',
                            },
                        ]
                    },
                    {
                        name: 'Statistiques',
                        path: 'statistics.index',
                        icon: 'icon-pie-chart',
                    },
                ]
            }
        }
    }
</script>

<style lang="scss" scoped>
    .cd-accordion__input { // hide native checkbox
        position: absolute;
        opacity: 0;
    }
    .cd-accordion__sub {
        display: none; // by default hide all sub menus
    }

    .cd-accordion__input:checked ~ .cd-accordion__sub { // show children when item is checked
        display: block;
    }

</style>
