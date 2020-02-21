<template>
    <ValidationProvider tag="div"
                        :name="id"
                        v-slot="{ errors }"
                        class="wrap-field validate-input relative flex flex-wrap items-end w-full h-20 bg-white border border-solid border-grey rounded-xl">
        <span class="icon-right-field" v-if="isLoading">
            <spinner />
        </span>
        <input
            type="text"
            v-model="search"
            :id="id"
            :name="id"
            @focus="handleFocus"
            @blur="focusOut"
            @input="onChange"
            @keydown.down="onArrowDown"
            @keydown.up="onArrowUp"
            @keydown.enter="onEnter"
            class="search field block w-full h-full bg-transparent text-black px-10 outline-none"
            :class="{ 'has-val': search, 'input-error': errors[0] }"
            autocomplete="off"
            @keydown.shift.tab.prevent=""
            :ref="'search'+id"
            :required="required"
        >
        <span class="focus-field absolute block border border-solid border-purple1 rounded-xl invisible opacity-0 pointer-events-none"></span>
        <label :for="id" class="label-field absolute left-0 block w-full pl-10 text-black pointer-events-none">{{ label }}</label>
        <span class="symbol-left-field"><i class="icon-search"></i></span>
        <span class="absolute top-14 px-5 text-red1 text-xs leading-tight tracking-wider font-semibold mt-1">{{ errors[0] }}</span>
        <div v-show="isOpen"
             class="wrap-autocomplete-results shadow-md">
            <ul class="list-autocomplete-results">
                <li v-if="placeholder"
                    class="item-autocomplete-result disabled">
                    Type at least 3 characters...
                </li>
                <li v-if="isLoading"
                    class="item-autocomplete-result disabled">
                    Loading results...
                </li>
                <li v-for="(suggestion, i) in matches"
                    :key="i"
                    @click="setResult(suggestion)"
                    class="item-autocomplete-result"
                    :class="{ 'is-active': i === arrowCounter }"
                >
                    <span class="block text-purple2 tracking-widest uppercase mr-2" v-if="suggestion.alias && suggestion.alias !== ''">
                        [{{ suggestion.alias }}]
                    </span>
                    {{ suggestion.name }} {{ suggestion.lastname || '' }}
                </li>

                <li v-if="searchMore"
                    @click="searchForMore"
                    class="item-autocomplete-result">
                    Chercher plus...
                </li>
            </ul>
        </div>
    </ValidationProvider>
</template>

<script>
    import spinner from '../elements/loader';

    export default {
        name: "autocomplete",
        components: {
            spinner
        },
        props: {
            id: {
                type: String,
                required: false,
                default: ""
            },
            label: {
                type: String,
                required: true,
                default: "Nom"
            },
            focus: {
                type: Boolean,
                required: false,
                default: false
            },
            suggestions: {
                type: [Array, Object],
                required: true,
                default: () => []
            },
            value: {
                type: String,
                required: false,
                default: ''
            },
            isAsync: {
                type: Boolean,
                required: false,
                default: false
            },
            required: {
                type: Boolean,
                required: false,
                default: false
            },
            searchMore: {
                type: Boolean,
                required: false,
                default: false
            },
        },
        data() {
            return {
                modelValue: this.value,
                isOpen: false,
                matches: [],
                hasValue: false,
                isLoading: false,
                arrowCounter: -1,
                placeholder: true,
                productSelected: false,
                isFocus: false,
            }
        },
        mounted() {
            this.placeholder = true;
            if (this.focus) {
                this.$refs['search' + this.id].focus();
                this.isOpen = true;
            }
            if (!this.matches.length && this.suggestions.length) {
                this.matches = this.suggestions;
            }
            document.addEventListener('click', this.handleClickOutside);
        },
        created() {
            //
        },
        watch: {
            suggestions(value, oldValue) {
                this.isLoading = false;
                if (value.length !== oldValue.length) {
                    this.matches = value;
                    if (this.$refs['search' + this.id].hasFocus) this.isOpen = true;
                }
            },
        },
        computed: {
            search: {
                get() {
                    this.test = this.value;
                    return this.value;
                },
                set(search) {
                    this.$emit('input', search);
                }
            },
        },
        methods: {
            handleFocus() {
                this.isFocus = true;
                this.isOpen = true;
            },
            handleClickOutside(evt) {
                if (!this.$el.contains(evt.target) && !this.isFocus) {
                    this.isOpen = false;
                    this.arrowCounter = -1;
                    this.$emit('focusOut', this.productSelected);
                }
            },
            focusOut() {
                this.isFocus = false;
            },
            onArrowDown() {
                if (this.arrowCounter < this.matches.length) {
                    this.arrowCounter = this.arrowCounter + 1;
                }
            },
            onArrowUp() {
                if (this.arrowCounter > 0) {
                    this.arrowCounter = this.arrowCounter - 1;
                }
            },
            onEnter() {
                this.$refs['search' + this.id].value = this.matches[this.arrowCounter].name;
                this.productSelected = true;
                this.setResult(this.matches[this.arrowCounter]);
                this.isOpen = false;
                this.arrowCounter = -1;
            },
            onChange() {
                if (this.modelValue) { // difference between product enter and no product
                    this.productSelected = true;
                } else {
                    this.productSelected = false
                }
                if (this.$refs['search' + this.id].value.length > 2) {
                    this.placeholder = false;
                    this.searchResults();
                } else {
                    this.placeholder = true;
                    if (!this.matches.length) {
                        this.searchResults();
                    }
                }
            },
            searchResults() {
                if (this.isAsync) {
                    this.isLoading = true;
                    this.$emit('search');
                } else {
                    this.filterResults();
                    this.isOpen = true;
                }
            },
            filterResults() {
                this.matches = this.suggestions.filter(item => item.toLowerCase().indexOf(this.search.toLowerCase()) > -1);
            },
            setResult(result) {
                this.$emit('setResult', result);
                this.$refs['search' + this.id].value = result.name;
                this.isOpen = false;
            },
            searchForMore() {
                this.$emit('searchForMore');
            },
        },
        destroyed() {
            document.removeEventListener('click', this.handleClickOutside);
        }
    }
</script>

<style lang="scss" scoped>
    .icon-right-field {
        position: absolute;
        right: 0;
        top: 0;

        > * {
            position: relative !important;
            top: -.25rem;
            right: .25rem;
            transform: scale(0.5);
        }
    }
    .wrap-autocomplete-results {
        position: absolute;
        z-index: 1;
        top: 5rem;
        width: 100%;
        border-radius: 1rem;
        font-size: 1.25rem;
        background-color: theme('colors.white');

        .list-autocomplete-results {
            .item-autocomplete-result {
                cursor: pointer;
                display: flex;
                justify-content: flex-start;
                align-items: center;
                padding: 1rem 2rem;

                &.disabled {
                    cursor: initial;

                    &:hover {
                        background-color: transparent;
                    }
                }

                &.is-active,
                &:hover {
                    background-color: theme('colors.gray.200');

                    &:first-child {
                        border-radius: 1rem 1rem 0 0;
                    }
                    &:last-child {
                        border-radius: 0 0 1rem 1rem ;
                    }
                }

                &:not(:last-child) {
                    border-bottom: .1rem solid theme('colors.grey');
                }
            }
        }
    }

    .fields-are-small .wrap-field,
    .field-is-small.wrap-field {
        .wrap-autocomplete-results {
            top: 3.5rem;
        }
    }
</style>
