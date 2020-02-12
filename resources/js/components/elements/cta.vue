<template>
    <div class="w-full text-center mt-4">
        <button type="button"
                @click="click"
                class="button nav-link"
                :class="{ 'primary': primary }"
        >
            <div class="bottom"></div>
            <div class="top">
                <div class="label">{{ label }}</div>

                <div class="button-border button-border-left"></div>
                <div class="button-border button-border-top"></div>
                <div class="button-border button-border-right"></div>
                <div class="button-border button-border-bottom"></div>
            </div>
        </button>
    </div>
</template>

<script>
    export default {
        name: "Button",
        props: {
            label: {
                type: String,
                required: false,
                default: "Link"
            },
            path: {
                type: String,
                required: false,
                default: ''
            },
            primary: {
                type: Boolean,
                required: false,
                default: false
            },
        },
        data() {
            return {

            }
        },
        created() {
            //
        },
        methods: {
            click() {
                if (this.path !== "") this.$router.push({ name: this.path});
                this.$emit('click');
            }
        }
    }
</script>

<style lang="scss" scoped>
    .button {
        display: inline-block;
        position: relative;

        .bottom {
            position: absolute;
            left: .5rem;
            top: .5rem;
            width: 100%;
            height: 100%;
            border-radius: 2rem;
            background-color: theme('colors.purple3');
            display: block;
            -webkit-transition: all .15s ease-out;
            -moz-transition: all .15s ease-out;
            -o-transition: all .15s ease-out;
            transition: all .15s ease-out;
        }

        .top {
            position: relative;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            padding: 1rem 3rem;
            border-radius: 2rem;
            border: .2rem solid theme('colors.black');

            .label {
                font-family: sans-serif;
                font-weight: 700;
                color: theme('colors.black');
                font-size: 12px;
                line-height: 110%;
                letter-spacing: 0.1em;
                text-align: center;
                text-transform: uppercase;
                -webkit-transition: all .15s ease-out;
                -moz-transition: all .15s ease-out;
                -o-transition: all .15s ease-out;
                transition: all .15s ease-out;
            }
        }

        .button-border {
            position: absolute;
            /*background-color: theme('colors.red1');*/
            -webkit-transition: all .25s ease-out;
            -moz-transition: all .25s ease-out;
            -o-transition: all .25s ease-out;
            transition: all .25s ease-out;
        }

        .button-border-left {
            left: -2px;
            bottom: -2px;
            width: 2px;
            height: 0;
        }

        .button-border-top {
            left: -2px;
            top: -2px;
            width: 0;
            height: 2px;
        }

        .button-border-right {
            right: -2px;
            top: -2px;
            width: 2px;
            height: 0;
        }

        .button-border-bottom {
            right: -2px;
            bottom: -2px;
            width: 0;
            height: 2px;
        }

        &:hover {
            .bottom {
                left: 0;
                top: 0;
                background-color: theme('colors.purple4'); // white
            }

            .top {
                .label {
                    color: theme('colors.purple1');
                }

                .button-border-left,
                .button-border-right {
                    height: calc(100% + 2px);
                }

                .button-border-top,
                .button-border-bottom {
                    width: calc(100% + 2px);
                }
            }
        }

        &.primary {
            .bottom {
                background-color: theme('colors.yellow1');
            }

            &:hover {
                .bottom {
                    background-color: theme('colors.purple4');
                }
            }
        }
    }
</style>
