<template>
    <div class="sidebar fixed top-0 right-0 min-w-120 max-w-120 min-h-screen p-12 bg-purple1 rounded-tl-4xl rounded-bl-4xl">
        <slot name="sidebar">
            Sidebar sidebar
        </slot>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Dashboard component mounted.')
        }
    }
</script>

<style lang="scss">
    .sidebar {
        .fieldset {
            padding: 3rem 0 5rem 0;

            .legend {
                position: relative;
                width: 100%;
                font-size: 2.25rem;
                text-transform: uppercase;
                letter-spacing: .1em;
                color: theme('colors.purple4');

                &:after {
                    content: '';
                    position: absolute;
                    width: 100%;
                    margin-left: 1rem;
                    border-bottom: .1rem solid theme('colors.purple4');
                    transform: translateY(1.1rem);
                }
            }

            .focus-field {
                border-color: theme('colors.purple5');
            }

            .line-break {
                border-color: theme('colors.purple3');
                width: calc(100% + 6rem);
                margin: 2rem 0 2rem -3rem;
            }
        }
    }
</style>

