<template>
    <nav class="nav pb-32">
        <ul class="tracking-wide">
            <li v-for="(route, key) in routes"
                :key="key"
                class="list py-10 px-12 border-t-2 border-solid border-grey font-bold">
                <input class="cd-accordion__input"
                       type="checkbox"
                       :id="'group-' + key"
                       v-if="route.subitems">
                <label class="cd-accordion__label flex justify-start items-center w-full relative cursor-pointer hover:text-purple1"
                       :for="'group-' + key"
                       v-if="route.subitems">
                    <i class="text-2xl text-purple1 mr-6" :class="route.icon"></i>
                    {{ route.name }}
                    <i class="icon-arrow icon-arrow-left-circle text-purple2 absolute right-0"></i>
                </label>

<!--                TODO : transition-group doesn't work x2 + css -->
                <transition-group name="expand"
                                  mode="out-in"
                                  tag="ul"
                                  @beforeLeave="beforeLeave"
                                  @enter="enter"
                                  @afterEnter="afterEnter"
                                  class="cd-accordion__sub"
                                  v-if="route.subitems">
                    <li v-for="(subitem, index) in route.subitems"
                        :key="key + index"
                        class="list font-semibold my-6 ml-6">
                        <input class="cd-accordion__input"
                               type="checkbox"
                               :id="'group-' + key + index"
                               v-if="subitem.subitems">
                        <label class="cd-accordion__label relative block w-full cursor-pointer hover:text-purple1" :for="'group-' + key + index"
                               v-if="subitem.subitems">
                            {{ subitem.name }}
                            <i class="icon-arrow icon-arrow-left-circle text-purple2 absolute right-0"></i>
                        </label>

                        <transition-group name="expand"
                                          mode="out-in"
                                          tag="ul"
                                          class="cd-accordion__sub"
                                          v-if="subitem.subitems">
                            <li v-for="(val, pos) in subitem.subitems"
                                :key="key + index + pos"
                                class="list my-4 ml-4">
                                <input class="cd-accordion__input"
                                       type="checkbox"
                                       :id="'group-' + key + index + pos">
                                <label class="cd-accordion__label cursor-pointer hover:text-purple1" :for="'group-' + key + index + pos">
                                    <router-link :to="{ name: val.path }"
                                                 :key="key + index + pos"
                                                 @change="activeLevel(key, index)"
                                    >
                                        {{ val.name }}
                                    </router-link>
                                </label>
                            </li>
                        </transition-group>

<!--                        <router-link-->
<!--                            :to="{ name: subitem.path }"-->
<!--                            v-slot="{ isActive, isExactActive }"-->
<!--                            class="hover:text-purple1"-->
<!--                            v-else-->
<!--                        >-->
<!--                            <span :class="[isActive && 'router-link-active', isExactActive && 'router-link-exact-active']"-->
<!--                                  @click="activeLevel(key, index)">-->
<!--                                {{ subitem.name }}-->
<!--                            </span>-->
<!--                        </router-link>-->

                        <router-link :to="{ name: subitem.path }"
                                     :key="index"
                                     @click="activeLevel(key, index)"
                                     class="hover:text-purple1"
                                     v-else>
                            {{ subitem.name }}
                        </router-link>
                    </li>
                </transition-group>

                <router-link :to="{ name: route.path }"
                             :key="key"
                             class="flex justify-start items-center hover:text-purple1"
                             v-else>
                    <i class="text-2xl text-purple1 mr-6" :class="route.icon"></i>
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
                        name: 'Accueil',
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
                                path: 'invoices.index',
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
        },
        created() {

        },
        methods: {
            beforeLeave(element) {
                console.log("beforeLeave");
                this.prevHeight = getComputedStyle(element).height;
            },
            enter(element) {
                console.log("enter");
                const { height } = getComputedStyle(element);

                element.style.height = this.prevHeight;

                setTimeout(() => {
                    element.style.height = height;
                });
            },
            afterEnter(element) {
                console.log("afterEnter");
                element.style.height = 'auto';
            },
            activeLevel(parent1, parent2) {
                console.log(parent1);
                console.log(parent2);
                parent1 = parent1 || null;
                localStorage.setItem("parent1", parent1);

                parent2 = parent2 || null;
                localStorage.setItem("parent2", parent2);
            }
        }
    }
</script>

<style lang="scss" scoped>
    /*.expand-enter-active,*/
    /*.expand-leave-active {*/
    /*    transition-duration: 0.3s;*/
    /*    transition-property: height, opacity;*/
    /*    transition-timing-function: ease;*/
    /*    overflow: hidden;*/
    /*}*/

    .cd-accordion__sub {
        height: 0;
        overflow: hidden;
        transition: display .3s ease-in-out;
    }

    .cd-accordion__input { // hide native checkbox
        position: absolute;
        opacity: 0;

        + .cd-accordion__label .icon-arrow {
            transition: transform .3s ease-in-out;
        }

        &.checked,
        &:checked {
            ~ .cd-accordion__sub { // show children when item is checked
                height: auto;
            }

            + .cd-accordion__label .icon-arrow {
                transform: rotateZ(-90deg);
            }
        }
    }


    .router-link-exact-active {
        padding: .5rem 1.5rem;
        color: theme('colors.purple1');
        font-weight: 700;
        line-height: 2.1rem;
        background-color: theme('colors.purple5');
        border-radius: 2rem;
    }
</style>
