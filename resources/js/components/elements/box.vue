<template>
    <div class="bg-white rounded-2xl shadow-md p-8" style="height: calc(100vh - 20rem);">
        <slot name="content">
            Box container
        </slot>
    </div>
</template>

<script>
    export default {
        name: 'box',
    }
</script>

<style lang="scss" scoped>

</style>
