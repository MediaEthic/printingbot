<template>
    <div class="relative w-full min-h-screen central-content">
        <loader v-if="isLoading"></loader>
        <div class="w-full min-h-screen p-12 w-full">
            <slot name="content">
                Container
            </slot>
        </div>

        <sidebar>
            <div slot="sidebar">
                <slot name="sidebar">
                    Sidebar container
                </slot>
            </div>
        </sidebar>

    </div>
</template>

<script>
    import sidebar from './sidebar';
    import loader from '../elements/loader';

    export default {
        name: "container",
        components: {
            sidebar,
            loader,
        },
        props: {
            isLoading: {
                type: Boolean,
                required: false,
                default: false
            },
        }
    }
</script>

<style lang="scss" scoped>
    .central-content {
        width: calc(100% - 30rem);
    }
</style>
