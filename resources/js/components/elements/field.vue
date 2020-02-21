<template>
    <ValidationProvider tag="div"
                        :name="id"
                        :rules="rules"
                        v-slot="{ errors }"
                        :class="{ 'textarea': type === 'textarea', 'disabled': disabled }"
                        class="wrap-field validate-input relative flex flex-wrap items-end w-full h-20 bg-white border border-solid border-grey rounded-xl">
        <select v-if="type === 'select'"
                v-bind="$attrs"
                :type="type"
                v-on="$listeners"
                :value="value"
                @input="$emit('updateField', $event.target.value)"
                :name="id"
                :id="id"
                class="field select has-val block w-full h-full bg-transparent text-black px-10 outline-none"
                :class="{ 'has-val': value, 'input-error': errors[0] }"
                :required="required"
                :disabled="disabled"
                :readonly="readonly"
        >
            <option v-if="choose" value="" :disabled="disabledChoose">Choisir</option>
            <option
                v-for="(item, index) in items"
                :value="item.id" >
                {{ item.name || '' }} {{ item.lastname || '' }}
            </option>
        </select>

        <textarea v-else-if="type === 'textarea'"
                  v-bind="$attrs"
                  :type="type"
                  v-on="$listeners"
                  :value="value"
                  @input="$emit('updateField', $event.target.value)"
                  :name="id"
                  :id="id"
                  class="textarea field block w-full h-full bg-transparent text-black px-10 outline-none"
                  :class="{ 'has-val': value, 'input-error': errors[0] }"
                  rows="1"
                  :required="required"
                  :disabled="disabled"
                  :readonly="readonly"
                  @keydown="textareaAutosize"
        ></textarea>

        <input v-else
               :type="type"
               :name="id"
               :id="id"
               v-bind="$attrs"
               v-on="$listeners"
               :value="value"
               @input="$emit('updateField', $event.target.value)"
               class="field block w-full h-full bg-transparent text-black px-10 outline-none"
               :class="{ 'has-val': value, 'input-error': errors[0] }"
               :step="type === 'number' ? 0.0001 : ''"
               :required="required"
               :disabled="disabled"
               :readonly="readonly"
        >
        <span class="focus-field absolute block border border-solid border-purple1 rounded-xl invisible opacity-0 pointer-events-none"></span>
        <label class="label-field absolute left-0 block w-full pl-10 text-black pointer-events-none">{{ label }}</label>
        <span class="vee-validate absolute top-20 px-5 text-red1 text-xs tracking-wider font-semibold mt-1">{{ errors[0] }}</span>
    </ValidationProvider>
</template>

<script>
    const TYPES = [
        'text',
        'password',
        'email',
        'number',
        'url',
        'tel',
        'search',
        'color',
        'select',
        'textarea'
    ];
    const includes = types => type => types.includes(type);

    export default {
        name: "field",
        inheritAttrs: false,
        props: {
            label: {
                type: String,
                required: true,
                default: 'Input'
            },
            value: {
                type: [String, Number],
                required: false,
                default: ''
            },
            type: {
                type: String,
                required: true,
                default: 'text',
                validator (value) {
                    const isValid = includes(TYPES)(value);
                    if (!isValid) {
                        console.warn(`allowed types are ${TYPES}`);
                    }
                    return isValid;
                }
            },
            id: {
                type: String,
                required: true,
                default: ''
            },
            required: {
                type: Boolean,
                required: false,
                default: false
            },
            disabled: {
                type: Boolean,
                required: false,
                default: false
            },
            readonly: {
                type: Boolean,
                required: false,
                default: false
            },
            items: {
                type: [Object, Array],
                required: false,
                default: () => {}
            },
            choose: {
                type: Boolean,
                required: false,
                default: true
            },
            disabledChoose: {
                type: Boolean,
                required: false,
                default: true
            },
            rules: {
                type: String,
                required: false,
                default: ''
            },
        },
        model: {
            prop: "value",
            event: "updateField"
        },
        data() {
            return {
                //
            }
        },
        created() {
            //
        },
        computed: {
            //
        },
        methods: {
            textareaAutosize() {
                let textareaList = document.getElementsByTagName("textarea");
                for (let i = 0; i < textareaList.length; i++) {
                    let el = textareaList[i];
                    setTimeout(() => {
                        el.style.cssText = 'height:auto !important; padding:0 !important;';
                        let scrollHeight = el.scrollHeight;
                        el.style.cssText = 'height:' + scrollHeight + 'px !important; ';
                        if (el.value === "") {
                            el.style.cssText = 'height:100% !important; ';
                        }
                    }, 0);
                }
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

        &.textarea {
            height: auto !important;
        }

        &.disabled {
            background-color: theme('colors.gray.200');
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

            &[required] {
                &+ .focus-field + .label-field {
                    &:after {
                        content: "*";
                        margin-left: .25rem;
                        font-weight: bold;
                        color: theme('colors.red1');
                    }
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

        .symbol-left-field {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 2.5rem;
            height: 5rem;
            font-size: 1.5rem;
            color: theme('colors.purple1');
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
        position: relative;

        &.disabled {
            &.has-val:before {
                color: theme('colors.purple4');
            }

            .field {
                height: 5rem;
                background-color: transparent;
                border-color: theme('colors.purple4');
            }
        }

        &.has-val {
            &::before {
                content: attr(data-title);
                z-index: 1;
                position: absolute;
                top: .5rem;
                padding: 0 2.5rem;
                font-size: 1.2rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                color: theme('colors.purple2');
            }

            .field {
                padding: 1.5rem 2.5rem .5rem 2.5rem;
            }
        }

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
                display: block;
                content: attr(placeholder);
                position: absolute;
                top: 0;
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

        .mx-icon-calendar {
            color: theme('colors.purple2');
        }
    }


    // into table
    .fields-are-small > .table-cell {
        > .wrap-field {
            & + .textarea {
                border-top-left-radius: 0;
                border-top-right-radius: 0;
                border-top: 0;
            }

            > .field {
                padding: 0 1rem;

                &.search {
                    padding: 0 2.5rem;
                }
            }
        }
    }

    .fields-are-small .wrap-field,
    .wrap-field.field-is-small {
        margin: 0;
        width: 100% !important;
        height: 3.5rem;

        .field {
            min-height: 3.5rem;

            &.textarea {
                resize: none;
                padding: .75rem 1rem;
            }

            ~ .vee-validate {
                top: 3.5rem
            }
        }
        .label-field {
            display: none;
        }

        .symbol-left-field {
            height: 3.5rem;
        }
    }
</style>
