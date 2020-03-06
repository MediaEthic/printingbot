<template>
    <div class="relative w-full min-h-screen central-content">
        <loader v-if="isLoading"></loader>
        <div class="main-section-content w-full min-h-screen md:p-12">
            <slot name="content">
                Container
            </slot>
        </div>

      <div :class="{ 'pull' : pullSidebar }" class="sidebar z-10 fixed bottom-0 right-0 w-full overflow-x-hidden px-12 pt-4 bg-purple1 rounded-t-4xl md:top-0 md:bottom-0 md:right-0 md:min-w-120 md:max-w-120 md:min-h-screen md:rounded-tr-none md:rounded-bl-4xl md:p-12">
            <input type="checkbox" id="pull-sidebar" v-model="pullSidebar">
            <label for="pull-sidebar" :class="[ pullSidebar ? 'icon-arrow-down-circle' : 'icon-arrow-up-circle']"></label>
            <slot name="sidebar">
                Sidebar sidebar
            </slot>
        </div>
    </div>
</template>

<script>
    import loader from '../elements/loader';

    export default {
        name: "container",
        components: {
            loader,
        },
        props: {
            isLoading: {
                type: Boolean,
                required: false,
                default: false
            },
        },
        data() {
            return {
                pullSidebar: false
            }
        }
    }
</script>

<style lang="scss">
    .central-content {
        .main-section-content {
            .hero + * {
                padding: 2rem;
            }
        }
    }

    @media (min-width: 768px) {
        .central-content {
            width: calc(100% - 30rem) !important;

        }

        .sidebar {
            scrollbar-color: theme('colors.black') theme('colors.purple5');
            scrollbar-width: thin;
            &::-webkit-scrollbar {
                width: 1.25rem;
                background-color: theme('colors.purple5');
                border-radius: 1rem;
            }
            &::-webkit-scrollbar-thumb {
                background: theme('colors.black');
                border-radius: 1rem;
            }
        }
    }

    .sidebar {
        top: calc(100vh - 8rem);

        overflow-y: hidden;
        transition: 0.5s;

        &.pull {
            top: 10rem;
            overflow-y: scroll;
        }

         #pull-sidebar {
             display: none;
             width: 0;
             height: 0;
             position: absolute;
             visibility: hidden;
             opacity: 0;

             ~ label {
                 cursor: pointer;
                 display: block;
                 text-align: center;
                 color: theme('colors.purple5');
                 margin-bottom: 1rem;
             }

             &:checked {

             }
         }

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

            .wrap-field,
            .mx-datepicker {
                .focus-field {
                    border-color: theme('colors.purple5');
                }

                &.disabled {
                    background-color: transparent;
                    border-color: theme('colors.purple4');

                    .field {
                        color: theme('colors.white');

                        & + .focus-field + .label-field {
                            color: theme('colors.purple4');
                        }
                    }
                }
            }

            .line-break {
                border-color: theme('colors.purple3');
                width: calc(100% + 6rem);
                margin: 2rem 0 2rem -3rem;
            }
        }
    }

    @media (min-width: 768px) {
        .sidebar {
            #pull-sidebar {
                ~ label {
                    display: none;
                }
            }
        }
    }
</style>
