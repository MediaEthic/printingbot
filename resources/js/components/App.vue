<template>
    <div class="flex">
        <header class="sticky top-0 w-100 h-screen p-12">
            <router-link :to="{ name: 'dashboard' }"
                         tag="a"
                         title="Retour sur la page d'accueil"
                         class="block w-76 mx-auto">
                <img src="/assets/img/logo-ethic-software.png"
                     alt="Logotype Ethic Software" />
            </router-link>
            <div class="rounded-lg my-16">
                <img class="h-40 w-40 rounded-full mx-auto" src="/assets/img/avatar.svg" alt="Avatar de l'utilisateur">
                <div class="text-center m-4">
                    <h2 class="font-bold text-black tracking-wide">Emilie ROZIS</h2>
                    <p class="text-purple1 m-2">Développeuse</p>
                </div>
            </div>
            <Navbar></Navbar>
        </header>
        <main class="flex w-full">
            <router-view class=""></router-view>
            <aside class="sticky top-0 w-120 h-screen p-12">
                Aside
            </aside>
        </main>
    </div>
</template>

<script>
    import Navbar from './partials/navbar.vue';

    export default {
        name: "App",
        components: {
            Navbar
        },
    }
</script>

<style lang="scss" scoped>

</style>
