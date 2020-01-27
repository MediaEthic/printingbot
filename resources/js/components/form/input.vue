<template>
    <ValidationProvider v-if="type === 'select'"
                         tag="div"
                        :name="id"
                         v-slot="{ errors }"
                         class="wrap-field validate-input relative flex flex-wrap items-end w-full h-20 bg-white border border-solid border-grey rounded-xl">
        <select v-model="input"
                @change="onChange"
                :id="id"
                :name="id"
                class="field select has-val block w-full h-full bg-transparent text-black px-10 outline-none"
                :class="{ 'input-error': errors[0] }"
                :required="required">
            <option disabled value="">Choisir</option>
            <option v-for="(item, index) in items"
                    :value="item.id">
                {{ item.name }}
            </option>
        </select>
        <span class="focus-field absolute block border border-solid border-purple1 rounded-xl invisible opacity-0 pointer-events-none"></span>
        <label class="label-field absolute left-0 block w-full pl-10 text-black pointer-events-none">{{ label }}</label>
        <span class="absolute top-20 px-5 text-red1 text-xs tracking-wider font-semibold mt-1">{{ errors[0] }}</span>
    </ValidationProvider>

    <ValidationProvider v-else-if="type === 'textarea'"
                         tag="div"
                        :name="id"
                         v-slot="{ errors }"
                        :class="{'disabled': disabled}"
                         class="wrap-field textarea validate-input relative flex flex-wrap items-end w-full bg-white border border-solid border-grey rounded-xl">
        <textarea @input="onChange"
                  v-model="input"
                  :id="id"
                  :name="id"
                  class="field block w-full h-full bg-transparent text-black px-10 outline-none"
                  :class="{ 'has-val': input, 'input-error': errors[0] }"
                  :disabled="disabled"
                  :required="required"
                  @keydown="textareaAutosize"
        ></textarea>
        <span class="focus-field absolute block border border-solid border-purple1 rounded-xl invisible opacity-0 pointer-events-none"></span>
        <label :for="id" class="label-field absolute left-0 block w-full pl-10 text-black pointer-events-none">{{ label }}</label>
        <span class="absolute top-20 px-5 text-red1 text-xs tracking-wider font-semibold mt-1">{{ errors[0] }}</span>
    </ValidationProvider>

    <ValidationProvider v-else
                         tag="div"
                        :name="id"
                         v-slot="{ errors }"
                        :class="{'disabled': disabled}"
                         class="wrap-field validate-input relative flex flex-wrap items-end w-full h-20 bg-white border border-solid border-grey rounded-xl">
        <input :type="type"
               @input="onChange"
               v-model="input"
               :id="id"
               :name="id"
               class="field block w-full h-full bg-transparent text-black px-10 outline-none"
               :class="{ 'has-val': input, 'input-error': errors[0] }"
               :disabled="disabled"
               :required="required"
        >
        <span class="focus-field absolute block border border-solid border-purple1 rounded-xl invisible opacity-0 pointer-events-none"></span>
        <label :for="id" class="label-field absolute left-0 block w-full pl-10 text-black pointer-events-none">{{ label }}</label>
        <span class="absolute top-20 px-5 text-red1 text-xs tracking-wider font-semibold mt-1">{{ errors[0] }}</span>
    </ValidationProvider>
</template>

<script>
    export default {
        name: "formInput",
        props: {
            type: {
                type: String,
                required: true,
                default: "text"
            },
            id: {
                type: String,
                required: false,
                default: ""
            },
            label: {
                type: String,
                required: true,
                default: "Input"
            },
            disabled: {
                type: Boolean,
                required: false,
                default: false
            },
            required: {
                type: Boolean,
                required: false,
                default: false
            },
            items: {
                type: Array,
                required: false,
                default: () => []
            },
        },
        data() {
            return {
                input: "",
            }
        },
        created() {

        },
        methods: {
            textareaAutosize() {
                let textareaList = document.getElementsByTagName("textarea");
                for (let i = 0; i < textareaList.length; i++) {
                    let el = textareaList[i];
                    setTimeout(() => {
                        el.style.cssText = 'height:auto !important; padding:0 !important;';
                        let scrollHeight = el.scrollHeight + 10;
                        el.style.cssText = 'height:' + scrollHeight + 'px !important; ';
                        if (el.value === "") {
                            el.style.cssText = 'height:100% !important; ';
                        }
                    }, 0);
                }
            },
            onChange() {
                this.$emit('input', this.input);
            },
        }
    }
</script>

<style lang="scss">
    .wrap-field,
    .mx-datepicker {
        // needed for width size sinon dépasse des blocks avec les marges
        display: inline-block !important;
        width: calc(100% - 1rem) !important;
        margin: .5rem;

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

        .label-field {
            top: 1.65rem;
            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;
        }


        .field {
            &.input-error {
                &+ .focus-field {
                    border-color: theme('colors.red1');
                }
            }

            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;

            &:disabled,
            &[disabled],
            &.select,
            &:focus,
            &.has-val {
                height: 3.5rem;

                &+ .focus-field + .label-field {
                    top: .5rem;
                    font-size: 1.2rem;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 0.1em;
                    color: theme('colors.purple2');
                }
            }
        }

        .focus-field {
            width: calc(100% + .2rem);
            height: calc(100% + .2rem);
            top: -.1rem;
            left: -.1rem;

            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;

            -webkit-transform: scaleX(1.1) scaleY(1.3);
            -moz-transform: scaleX(1.1) scaleY(1.3);
            -ms-transform: scaleX(1.1) scaleY(1.3);
            -o-transform: scaleX(1.1) scaleY(1.3);
            transform: scaleX(1.1) scaleY(1.3);
        }

        .field:focus + .focus-field {
            visibility: visible;
            opacity: 1;

            -webkit-transform: scale(1);
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            -o-transform: scale(1);
            transform: scale(1);
        }
    }

    // only pour classe wrap-field sinon bug avec mx-datepicker
    .wrap-field {
        .field {
            position: absolute;
            bottom: 0;
        }
    }

    textarea {
        position: initial !important;
    }


    // input date
    .mx-datepicker {
        .field {
            outline: none;
            width: 100%;
            height: 5rem;
            background-color: theme('colors.white');
            border: .1rem solid theme('colors.grey');
            border-radius: 1rem;
            padding: .5rem 2.5rem;
            color: theme('colors.purple1');

            &::before {
                content: attr(placeholder);
                position: absolute;
                font-size: 2rem;
                letter-spacing: .1em;
                font-weight: 700;
                text-transform: uppercase;
                /*color: theme('colors.black');*/
            }

            &::placeholder {
                position: absolute;
                top: 0;
                color: theme('colors.black');
            }

            &:focus {
                height: 5rem;
            }
        }
    }



    .table-cell {
        > .wrap-field {
            margin: 0;
            width: 100% !important;
            height: 3.5rem;

            .field {
                padding: 0 1.5rem;
            }
            .label-field {
                display: none;
            }
        }

        > .textarea {
            height: auto;
        }
    }
</style>
