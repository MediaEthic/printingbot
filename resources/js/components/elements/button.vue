<template>
    <div v-if="type === 'cta' || type === 'submit'" class="w-full text-center mt-4">
        <button :type="type === 'submit' ? 'submit' : 'button'"
                @click="clicked"
                class="cta nav-link"
                :class="{ 'primary': primary }"
                :disabled="disabled"
        >
            <div class="bottom"></div>
            <div :class="[ !responsive ? 'px-12' : '' ]" class="top p-4 sm:px-12">
                <div class="label"><i :class="[ icon, !responsive ? 'hidden' : '' ]" class="sm:hidden"></i><span :class="[ responsive ? 'hidden' : '' ]" class="sm:inline">{{ label }}</span></div>

                <div class="button-border button-border-left"></div>
                <div class="button-border button-border-top"></div>
                <div class="button-border button-border-right"></div>
                <div class="button-border button-border-bottom"></div>
            </div>
        </button>
    </div>

    <button v-else-if="type === 'button'" type="button"
            class="button"
            @click.prevent="clicked">
        <span class="wrap-icon icon-arrow before">
            <i class="icon" :class="icon"></i>
        </span>
        <span class="label">{{ label }}</span>
        <span class="wrap-icon icon-arrow after">
            <i class="icon" :class="icon"></i>
        </span>
    </button>

    <a v-else-if="type === 'link'" role="button"
       :href="path"
       :target="target"
       class="button">
        <span class="wrap-icon icon-arrow before">
            <i class="icon" :class="icon"></i>
        </span>
        <span class="label">{{ label }}</span>
        <span class="wrap-icon icon-arrow after">
            <i class="icon" :class="icon"></i>
        </span>
    </a>

    <button v-else-if="type === 'delete'"
            type="button"
            class="button-delete"
            @click.prevent="clicked">
        <div class="bin-icon">
            <div class="lid"></div>
            <div class="box">
                <div class="box-inner">
                    <div class="bin-lines"></div>
                </div>
            </div>
        </div>
    </button>
</template>

<script>
    const TYPES = [
        'cta',
        'submit',
        'button',
        'link',
        'delete',
    ];
    const includes = types => type => types.includes(type);

    export default {
        name: "Button",
        props: {
            type: {
                type: String,
                required: true,
                default: 'button',
                validator (value) {
                    const isValid = includes(TYPES)(value);
                    if (!isValid) {
                        console.warn(`allowed types are ${TYPES}`);
                    }
                    return isValid;
                }
            },
            label: {
                type: String,
                required: false,
                default: "Link"
            },
            responsive: {
                type: Boolean,
                required: false,
                default: true
            },
            path: {
                type: String,
                required: false,
                default: "/"
            },
            target: {
                type: String,
                required: false,
                default: "_self"
            },
            primary: {
                type: Boolean,
                required: false,
                default: false
            },
            icon: {
                type: String,
                required: false,
                default: "icon-arrow-right"
            },
            disabled: {
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

        },
        methods: {
            clicked() {
                this.$emit('click');
            }
        }
    }
</script>

<style lang="scss" scoped>
    button:disabled,
    button[disabled] {
        cursor: not-allowed;
    }
    .cta {
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

        &.primary:not([disabled]) {
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

    .button {
        display: block;
        position: relative;
        margin: 0 0 .5rem 0;
        padding: 1.4rem 1.25rem 1.4rem 6.5rem;
        height: 5.6rem;
        border: 0;
        background: transparent;
        transition: all 0.2s ease;
        outline: none;

        &:focus {
            border: .1rem solid theme('colors.black');
            border-radius: 3rem;
        }

        &:not(:disabled) {
            cursor: pointer;
        }

        &:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            display: block;
            border-radius: 2.8rem;
            background: theme('colors.purple4');
            width: 5rem;
            height: 5rem;
            transition: all 0.3s ease;
        }

        .label,
        .wrap-icon {
            backface-visibility: hidden;
            transform: translateZ(0);
            perspective: 1000;
        }

        .wrap-icon {
            top: 1.25rem;
            font-size: 2.5rem;
            transition: transform .5s cubic-bezier(0.86, 0, 0.07, 1), opacity .4s cubic-bezier(0.86, 0, 0.07, 1);

            &.before {
                position: absolute;
                left: 1.25rem;
                transform-origin: left center;
            }

            &.after {
                position: absolute;
                opacity: 0;
                right: 1.25rem;
                transform: translateX(75%) scaleX(0.1);
                transform-origin: right center;
            }
        }

        .label {
            position: relative;
            font-size: 1.5rem;
            line-height: 2.2rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: theme('colors.white');
            vertical-align: middle;
            display: inline-block;
            transition: transform .5s cubic-bezier(0.86, 0, 0.07, 1);
        }

        &:hover {
            background-color: transparent;

            &:before {
                width: 100%;
                background: theme('colors.purple5');
            }

            .label {
                transform: translateX(-4.5rem);
                color: theme('colors.purple1');
            }

            .wrap-icon {
                color: theme('colors.black');

                &.before {
                    opacity: 0;
                    transform: translateX(-75%) scaleX(0.1);
                }

                &.after {
                    opacity: 1;
                    transform: translateX(0) scaleX(1);
                }
            }
        }

        &:active {
            transform: scale(0.96);
            border-color: #FD6154;
            color: #FD6154;
        }

        &:disabled,
        &[disabled] {
            cursor: not-allowed;

            &:before {
                background: theme('colors.purple3');
            }

            span {
                color: theme('colors.purple2');
            }

            svg {
                stroke: theme('colors.purple2');
            }
        }
    }


    .button-delete {
        z-index: 1;
        cursor: pointer;
        position: absolute;
        top: 0;
        width: 6rem;
        height: 15rem;
        margin: 0 auto;
        /*background-color: theme('colors.white');*/
        border-radius: 50%;
        overflow: hidden;
        transform-origin: 0 0;
        transform: scale(.3);

        .bin-icon {
            position: absolute;
            top: 50%;
            right: 0;
            left: 0;
            width: 42px;
            height: 58px;
            margin: 0 auto;
            border-radius: 50%;
            z-index: 2;

            .lid {
                position: relative;
                width: 50px;
                height: 4px;
                left: -4px;
                border-radius: 4px;

                &:before {
                    content: '';
                    position: absolute;
                    top: -4px;
                    right: 0;
                    left: 0;
                    width: 10px;
                    height: 6px;
                    margin: 0 auto;
                    border-radius: 10px 10px 0 0;
                }
            }

            .box {
                position: relative;
                height: 52px;
                margin-top: 2px;
                border-radius: 0 0 8px 8px;

                .box-inner {
                    position: relative;
                    top: 4px;
                    width: 34px;
                    height: 44px;
                    margin: 0 auto;
                    background-color: theme('colors.white');
                    border-radius: 0 0 5px 5px;

                    .bin-lines {
                        position: relative;
                        top: 7px;
                        margin: 0 auto;

                        &:before,
                        &:after {
                            content: '';
                            position: absolute;
                        }

                        &:before {
                            left: 1rem;
                        }

                        &:after {
                            left: 2rem;
                        }
                    }

                    .bin-lines {
                        &:before,
                        &:after {
                            width: 3px;
                            height: 30px;
                            border-radius: 4px;
                        }
                    }
                }
            }

            .lid,
            .lid:before,
            .box,
            .bin-lines,
            .bin-lines:before,
            .bin-lines:after {
                background-color: theme('colors.red1');
                transition: 0.2s ease background-color;
            }
        }

        &:hover {
            .bin-icon {
                .lid,
                .lid:before,
                .box,
                .box-inner {
                    background-color: theme('colors.red1');
                }

                .bin-lines,
                .bin-lines:before,
                .bin-lines:after {
                    background-color: theme('colors.white');
                }
            }

            .bin-icon {
                .box {
                    animation: shake 0.2s ease 0.1s;
                }

                .lid {
                    animation: lift-up 0.8s ease 0.1s, shake_u 0.8s ease 0.1s, shake_l 0.2s ease 0.8s;
                }
            }
        }

        @keyframes shake
        {
            0%{  transform: rotateZ(3deg); }
            25%{  transform: rotateZ(0);}
            75%{ transform: rotateZ(-3deg); }
            100%{ transform: rotateZ(0); }
        }

        @keyframes lift-up
        {
            0%{ top:0; }
            50%{ top:-35px;}
            100%{ top:0; }
        }

        @keyframes shake_u
        {
            0%{ transform: rotateZ(0); }
            25%{ transform:rotateZ(-15deg); }
            50%{ transform:rotateZ(0deg); }
            75%{ transform:rotateZ(15deg); }
            100%{ transform:rotateZ(0); }
        }

        @keyframes shake_l
        {
            0%{ transform:rotateZ(0); }
            80%{ transform:rotateZ(3deg); }
            90%{ transform:rotateZ(-3deg); }
            100%{ transform:rotateZ(0); }
        }
    }
</style>
