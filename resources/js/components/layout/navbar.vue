<template>
    <div class="nav-top" :class="{ 'nav-is-toggled': showMenu }">
        <div id="menu-btn" @click="showMenu = !showMenu">
            <span class="icon"></span>
            <span class="text">MENU</span>
        </div>

        <nav class="nav-drill">
            <div>
                <router-link :to="{ name: 'dashboard.index' }"
                             tag="a"
                             title="Retour sur la page d'accueil"
                             class="block w-76 mx-auto px-12 pt-12">
                    <img src="/assets/img/logo-ethic-software.png"
                         alt="Logotype Ethic Software" />
                </router-link>
                <div class="rounded-lg my-16 px-12">
                    <img class="h-40 w-40 rounded-full mx-auto" src="/assets/img/avatar.svg" alt="Avatar de l'utilisateur">
                    <div class="text-center m-4 tracking-wide">
                        <h2 class="font-bold text-black tracking-wide">Emilie ROZIS</h2>
                        <p class="font-semibold text-purple1 m-2">Développeuse</p>
                    </div>
                </div>
            </div>

            <ul class="nav-items nav-level-1">
                <li
                    v-for="route in routes"
                    v-if="route.subitems"
                    class="nav-item nav-expand">
                    <a class="nav-link nav-expand-link" href="javascript:;">
                        <span>{{ route.name }}</span>
                    </a>
                    <ul class="nav-items nav-expand-content">
                        <li class="nav-item-back-link">
                            <a class="nav-back-link" href="javascript:;">
                                Retour
                            </a>
                        </li>
                        <li
                            v-for="subitem in route.subitems"
                            v-if="subitem.subitems"
                            class="nav-item nav-expand">
                            <a class="nav-link nav-expand-link" href="javascript:;">
                                {{ subitem.name }}
                            </a>
                            <ul class="nav-items nav-expand-content">
                                <li class="nav-item-back-link">
                                    <a class="nav-back-link" href="javascript:;">
                                        Retour
                                    </a>
                                </li>
                                <li
                                    v-for="subsubitem in subitem.subitems"
                                    class="nav-item">
                                    <router-link tag="a" :to="{ name: subsubitem.path }" class="nav-link">
                                        {{ subsubitem.name }}
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                        <li
                            v-else
                            class="nav-item">
                            <router-link tag="a" :to="{ name: subitem.path }" class="nav-link">
                                {{ subitem.name }}
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li
                    v-else
                    class="nav-item">
                    <router-link tag="a" :to="{ name: route.path }" class="nav-link">
                        {{ route.name }}
                    </router-link>
                </li>
            </ul>


            <btn type="cta"
                 label="Déconnexion"
                 :responsive="false"
                 v-on:click="logout"
                 class="absolute bottom-12" />
        </nav>
    </div>
</template>

<script>
    import btn from "../elements/button";

    export default {
        name: "Navbar",
        components: {
            btn
        },
        data() {
            return {
                showMenu: false,
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
        mounted() {
            const navExpand = [].slice.call(document.querySelectorAll('.nav-expand'));
            navExpand.forEach(item => {
                // item.querySelector('.nav-expand-content').insertAdjacentHTML('afterbegin', backLink);
                item.querySelector('.nav-link').addEventListener('click', () => item.classList.add('active'));
                item.querySelector('.nav-back-link').addEventListener('click', () => item.classList.remove('active'));
            });

            document.addEventListener('click', this.handleClickOutside);
        },
        methods: {
            handleClickOutside(evt) {
                if (!this.$el.contains(evt.target)) {
                    this.showMenu = false;
                }
            },
            logout() {
                console.log("logout");
            }
        },
        destroyed() {
            document.removeEventListener('click', this.handleClickOutside);
        }
    }
</script>

<style lang="scss" scoped>
$burger_anim_time: 1s;
$burger_scale: .5;

.nav-top {
    display: flex;
    align-items: center;
    position: absolute;
    z-index: 10;
    height: 8rem;

    &.nav-is-toggled {
        top: 0;
        left: 29rem;
        width: 4.5rem;
        height: 3.5rem;
        border-radius: 0 2rem 2rem 0;
        background-color: theme('colors.black');

        #menu-btn {
            position: fixed;
            top: -2rem;
            right: 0;
            transform: scale(0.25);

            &:before,
            &:after {
                background-color: theme('colors.white');
            }

            &:before {
                animation: topBar_open $burger_anim_time ease-in-out;
                animation-fill-mode: forwards;
            }

            &:after {
                animation: bottomBar_open $burger_anim_time ease-in-out;
                animation-fill-mode: forwards;
            }

            .text {
                animation: menuLabel_open $burger_anim_time ease-in;
                animation-fill-mode: forwards;
            }

        }

        .nav-drill {
            transform: translateX(0);
        }
        &::after {
            opacity: 1;
            visibility: visible;
        }
    }


    //OPEN
    @keyframes topBar_open {
        0% { transform: translateY(0px) rotate(0deg); width: 60px; }
        10% {transform: translateY(-8px) rotate(0deg); width: 60px; }
        50% {transform: translateY(25px) rotate(45deg); width: 84px; }
        75% {transform: translateY(12px) rotate(45deg); width: 84px; }
        100% {transform: translateY(17px) rotate(45deg); width: 84px; }
    }

    @keyframes bottomBar_open {
        0% { transform: translateY(0px) rotate(0deg); width: 60px; }
        10% { transform: translateY(-8px) rotate(0deg); width: 60px; }
        60% {transform: translateY(0px) rotate(-45deg); width: 84px; }
        75% {transform: translateY(-10px) rotate(-45deg); width: 84px; }
        100% {transform: translateY(-8px) rotate(-45deg); width: 84px; }
    }

    @keyframes menuLabel_open {
        0% { transform: translateY(0px); opacity: 1; }
        25% {transform: translateY(-18px); }
        45% {transform: translateY(44px); opacity: 1; }
        48% {transform: translateY(50px); opacity: 0; }
        100% {transform: translateY(30px); opacity: 0; }
    }

    // CLOSE
    @keyframes topBar_close {
        0% {transform: translateY(17px) rotate(45deg); width: 84px; }
        35% {transform: translateY(-8px) rotate(-4deg); width: 60px; }
        53% {transform: translateY(10px) rotate(3deg); width: 60px; }
        70% {transform: translateY(-6px) rotate(0deg); width: 60px; }
        100% { transform: translateY(-2px) rotate(0deg); width: 60px; }
    }

    @keyframes bottomBar_close {
        0% {transform: translateY(-8px) rotate(-45deg); width: 84px; }
        35% {transform: translateY(-18px) rotate(6deg); width: 60px; }
        53% {transform: translateY(0px) rotate(-3deg); width: 60px; }
        68% { transform: translateY(-7px) rotate(0deg); width: 60px; }
        100% { transform: translateY(0px) rotate(0deg); width: 60px; }
    }

    @keyframes menuLabel_close {
        0% {transform: translateY(30px); opacity: 0; }
        5% {transform: translateY(25px); opacity: 1; }
        25% {transform: translateY(-30px); opacity: 1; }
        37% {transform: translateY(-22px); opacity: 1; }
        45% {transform: translateY(-22px); opacity: 1; }
        58% {transform: translateY(8px) rotate(-10deg); opacity: 1; }
        83% {transform: translateY(-6px) rotate(0deg); opacity: 1; }
        100% { transform: translateY(0px); opacity: 1; }
    }

    #menu-btn {
        display: block;
        position: relative;
        text-align: center;
        width: 6rem;
        height: 6.5rem;
        transform: scale($burger_scale);
        transition: .45s;

        &:before,
        &:after {
            content: '';
            width: 100%;
            height: 8px;
            background-color: theme('colors.black');
            display: block;
            position: absolute;
            border-radius: 20px;
        }

        &:before {
            transform-origin: left center;
            animation: topBar_close $burger_anim_time ease-in-out;
            animation-fill-mode: forwards;
        }

        &:after {
            right: 0;
            top: 25px;
            transform-origin: right center;
            animation: bottomBar_close $burger_anim_time ease-in-out;
            animation-fill-mode: forwards;
        }

        .text {
            color: theme('colors.black');
            display: block;
            position: absolute;
            bottom: 0;
            font-size: 17px;
            font-weight: 600;
            letter-spacing: 2.5px;
            animation: menuLabel_close $burger_anim_time ease-in;
            animation-fill-mode: forwards;
        }

        &:hover {
            cursor: pointer;
        }
    }



    .nav {
        &-drill {
            display: flex;
            position: fixed;
            flex-flow: column nowrap;
            z-index: 100;
            top: 0;
            left: 0;
            width: calc(100% - 5rem);
            max-width: 30rem;
            height: 100vh;
            background-color: theme('colors.white');
            border-radius: 0 1rem 1rem 0;
            transform: translateX(-100%);
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            transition: 0.45s;


            scrollbar-color: theme('colors.purple1') theme('colors.purple5');
            scrollbar-width: thin;
            &::-webkit-scrollbar {
                width: 1rem;
                background-color: theme('colors.purple5');
                border-radius: 1rem;
            }
            &::-webkit-scrollbar-thumb {
                background: theme('colors.purple1');
                border-radius: 1rem;
            }
        }

        &-items {
            flex: 0 0 100%;
        }

        &-item {
            > .nav-link:hover,
            > .router-link-exact-active {
                background-color: theme('colors.black');
                color: theme('colors.white');
                border-radius: 4rem;
                margin: 1rem;
            }

            &:not(:last-child) {
                border-bottom: .2rem solid theme('colors.grey');
            }
        }

        &-link {
            display: block;
            padding: 2rem 2.5rem;
            color: theme('colors.black');
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        &-expand {
            &-content {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 0;
                transform: translateX(-100%);
                background-color: theme('colors.white');
                transition: 0.3s;
                visibility: hidden;

                .nav-item {
                    &:not(:last-child) {
                        border-bottom: .2rem solid theme('colors.grey');
                    }
                }

                .nav-back-link {
                    display: flex;
                    align-items: center;
                    padding: 2rem 2.5rem;
                    font-weight: 700;
                    letter-spacing: 0.02em;
                    text-transform: uppercase;

                    &::before {
                        font-family: 'icomoon' !important;
                        content: "\e912"; // icon-arrow-left-circle
                        color: theme('colors.purple1');
                        margin-right: 1rem;
                    }
                }
            }

            &-link {
                display: flex;
                justify-content: space-between;

                &::after {
                    font-family: 'icomoon' !important;
                    content: "\e914"; // icon-arrow-right-circle
                    flex: 0 1 auto;
                    color: theme('colors.purple1');
                }
            }

            &.active {
                > .nav-expand-content {
                    height: 100%;
                    transform: translateX(0);
                    visibility: visible;
                }
            }

            .nav-expand-content {
                top: 31rem;
                background-color: theme('colors.purple5');

                .nav-expand-content {
                    top: 0;
                    background-color: theme('colors.purple4');
                }
            }
        }
    }
}

@media screen and (min-width: 350px) { // define by nav-drill with (30 rem) + close menu (5 rem)
    .nav-top {
        &.nav-is-toggled {
            #menu-btn {
                top: -2rem;
                left: 28.5rem;
            }
        }
    }
}

@media screen and (min-width: 768px) {
    .nav-top {
        top: 4.5rem;
        border-radius: 0 2rem 2rem 0;
        background-color: theme('colors.black');
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        transition: all .3s;

        /*&.nav-is-toggled {*/
        /*    top: 0;*/
        /*    left: 29rem;*/
        /*    width: 4.5rem;*/
        /*    height: 3.5rem;*/

        /*}*/

        #menu-btn {
            &:before,
            &:after {
                background-color: theme('colors.white');
            }

            .text {
                color: theme('colors.white');
            }
        }
    }
}
</style>
