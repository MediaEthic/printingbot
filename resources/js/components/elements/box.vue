<template>
    <div class="box bg-white rounded-2xl shadow-md m-8">
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
