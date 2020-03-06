<template>
    <div class="absolute flex justify-center items-center z-50 w-full h-full rounded-tl-4xl rounded-bl-4xl">
        <div class="absolute w-full h-full bg-white opacity-75"></div>
        <spinner></spinner>
    </div>
</template>

<script>
    import spinner from './spinner';

    export default {
        name: 'loader',
        components: {
            spinner,
        },
    }
</script>

<style lang="scss" scoped>

</style>
