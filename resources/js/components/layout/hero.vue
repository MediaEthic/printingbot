<template>
    <section class="relative bg-no-repeat bg-right bg-yellow1 rounded-2xl my-12">
        <img :src="'/assets/img/' + illustration"
             alt="content create" class="absolute right-12 -my-12" />
        <div class="relative flex flex-wrap justify-start items-center p-12">
            <div class="mr-16 font-serif font-bold text-5xl tracking-tighter">
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
