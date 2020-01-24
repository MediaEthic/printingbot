<template>
    <a role="button"
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
</template>

<script>
    export default {
        name: "Button",
        props: {
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
            label: {
                type: String,
                required: false,
                default: "Link"
            },
            icon: {
                type: String,
                required: false,
                default: "icon-arrow-right"
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
    .button {
        position: relative;
        display: block;
        margin: 0 0 .5rem 0;
        padding: 1.4rem 1.25rem 1.4rem 6.5rem;
        height: 5.6rem;
        border: 0;
        background: transparent;
        transition: all 0.2s ease;

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
</style>
