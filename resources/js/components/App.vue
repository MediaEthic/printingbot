<template>
    <div>
        <header>
            <navbar></navbar>
        </header>
        <main class="w-full min-h-screen bg-gray-200 pb-32 md:shadow-md md:p-0">
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

    const DEFAULT_TRANSITION = 'fade';

    export default {
        name: "App",
        components: {
            navbar
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
        }
    }
</script>

<style lang="scss">

</style>
