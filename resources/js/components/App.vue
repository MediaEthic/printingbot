<template>
    <div class="table w-full min-h-screen">
        <div class="menu table-cell align-top min-w-100 max-w-100 min-h-screen">
            <input id="toggle" type="checkbox">
            <label for="toggle">
                <i class="icon-menu"></i>
                Menu
            </label>

            <header class="main-header sticky top-0 w-full">
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
                <navbar></navbar>
                <cta :label="`Déconnexion`"
                     v-on:click="logout"
                     class="absolute bottom-12"
                ></cta>
            </header>
        </div>
        <main class="table-cell align-top w-full min-h-screen bg-gray-200 rounded-tl-4xl rounded-bl-4xl shadow-md">
            <transition
                :name="transitionName"
                mode="out-in"
                @beforeLeave="beforeLeave"
                @enter="enter"
                @afterEnter="afterEnter"
            >
                <router-view></router-view>
            </transition>
        </main>
    </div>
</template>

<script>
    import navbar from './layout/navbar';
    import cta from './elements/cta';

    const DEFAULT_TRANSITION = 'fade';

    export default {
        name: "App",
        components: {
            navbar,
            cta,
        },
        data() {
            return {
                prevHeight: 0,
                transitionName: DEFAULT_TRANSITION,
            }
        },
        created() {
            this.$router.beforeEach((to, from, next) => {
                let transitionName = to.meta.transitionName || from.meta.transitionName;

                if (transitionName === 'slide') {
                    const toDepth = to.path.split('/').length;
                    const fromDepth = from.path.split('/').length;
                    transitionName = toDepth < fromDepth ? 'slide-right' : 'slide-left';
                }

                this.transitionName = transitionName || DEFAULT_TRANSITION;

                next();
            });
        },
        methods: {
            beforeLeave(element) {
                this.prevHeight = getComputedStyle(element).height;
            },
            enter(element) {
                const { height } = getComputedStyle(element);

                element.style.height = this.prevHeight;

                setTimeout(() => {
                    element.style.height = height;
                });
            },
            afterEnter(element) {
                element.style.height = 'auto';
            },
            logout() {
                console.log("logout");
            }
        }
    }
</script>

<style lang="scss">
    .menu {
        .main-header {
            &:before {
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                content: '';
                width: 100vw;
                height: 100vh;
                background: rgba(0, 0, 0, 0.8);
                transition: all 500ms ease-in-out;

                // that's all the pen about
                clip-path: circle(30px at calc(100% - 65px) 65px);
                // for AT
                visibility: hidden;
            }
        }

        #toggle {
            &:checked {
                ~ .nav {
                    &:before {
                        visibility: visible;

                        // that's all the pen about
                        clip-path: circle(100%);
                    }
                }
            }
        }
    }
</style>
