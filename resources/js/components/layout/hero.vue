<template>
    <section class="hero relative bg-no-repeat bg-right bg-yellow1 rounded-b-2xl md:rounded-2xl md:ml-20 md:mb-20">
        <img :src="'/assets/img/' + illustration"
             alt="create content" class="absolute right-4 mt-4 max-h-32 md:right-12 md:max-h-68 md:-mt-10" />
        <div class="relative flex flex-wrap justify-start items-center px-24 py-6 md:p-12">
            <div class="mr-8 font-serif font-bold tracking-tighter text-3xl md:mr-16 md:text-5xl">
                    <slot name="title">
                        Hero title
                    </slot>
<!--                    <h2 class="subtitle">-->
<!--                        Hero subtitle-->
<!--                    </h2>-->
            </div>
            <div>
                <slot name="action">

                </slot>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "Hero",
        props: {
            illustration: {
                type: String,
                required: true,
                default: "index.svg"
            },
        },
        data() {
            return {

            }
        },
        created() {

        },
        methods: {

        }
    }
</script>

<style lang="scss" scoped>

</style>
