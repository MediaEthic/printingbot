<template>
    <span class="badge inline-flex justify-center items-center rounded-2xl py-2 px-3 bg-yellow1 text-black text-sm font-semibold whitespace-no-wrap"
          :class="[color === 'red' ? 'red' : '', color === 'purple' ? 'purple' : '']">
        {{ label }}
    </span>
</template>

<script>
    export default {
        name: "tag",
        props: {
            label: {
                type: String,
                required: false,
                default: "Tag label"
            },
            color: {
                type: String,
                required: false,
                default: "yellow"
            },
        },
        data() {
            return {

            }
        },
        created() {

        },
        methods: {
            setColor() {
                console.log(this.color);
                if (this.color === "yellow") {
                    return "yellow";
                } else if (this.color === "red") {
                    return "red";
                } else {
                    return "purple";
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .badge {
        &.red {
            background-color: theme('colors.red5');
            color: theme('colors.red1');
        }
        &.purple {
            background-color: theme('colors.purple5');
            color: theme('colors.purple1');
        }
    }
</style>
