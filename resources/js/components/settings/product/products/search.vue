<template>
    <modal name="search-products" :adaptive="true" @before-open="beforeOpen" :width="1180" :height="710">
        <loader v-if="isLoading"></loader>
        <div class="modal-container">
            <div class="modal-header">
                <h3 class="modal-title">Rechercher un article</h3>
                <button type="button"
                        class="modal-close"
                        aria-label="Fermer la fenêtre modale"
                        @click="hide">
                </button>

                <form action="#" method="post" class="form-filters">
                        <autocomplete
                            id="customers"
                            :suggestions="datas.products"
                            label="Article"
                            v-model="filters.product"
                            :isAsync="true"
                            :focus="false"
                            :required="false"
                            v-on:search="searchProductsForAutocomplete"
                        />

                    <btn type="button" class="modal-submit"
                         label="Rechercher"
                         icon="icon-search"
                         v-on:click="fetchProducts()"
                    />

                </form>
            </div>

            <div class="modal-body">
                <div v-if="allProducts.data">
                    <div class="container-table">
                        <table class="wrap-table table-selective">
                            <thead class="table-header">
                                <tr class="table-row">
                                    <th scope="col" class="table-cell"></th>
                                    <th scope="col" class="table-cell">Nom</th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                <tr v-for="(row, index) in allProducts.data"
                                    :key="index"
                                    class="table-row"
                                    @click="setSelection(row)"
                                >
                                    <td class="table-cell image"
                                        data-title="">
                                        <img class="max-w-xs h-16"
                                             :src="'/assets/img/products/' + row.image"
                                             alt="En attente d'une recherche"/>
                                    </td>
                                    <td class="table-cell name visible-title"
                                        data-title="Nom">
                                        <span class="text-purple2 tracking-widest uppercase mr-2">
                                            [{{ row.alias }}]
                                        </span>
                                        {{ row.name }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <pagination :pagination="pagination" v-on:pagechanged="fetchProducts"></pagination>
                </div>
                <div v-else>
                    <img :src="'/assets/img/empty_no_data.svg'"
                         alt="No customer found"
                         class="max-w-sm sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl mx-auto" />
                </div>
            </div>
        </div>
    </modal>
</template>

<script>
    import { mapGetters } from 'vuex';
    import loader from '../../../elements/loader';
    import autocomplete from '../../../form/autocomplete';
    import field from '../../../elements/field';
    import btn from '../../../elements/button';
    import pagination from '../../../elements/pagination';

    export default {
        name: "Search",
        components: {
            loader,
            autocomplete,
            field,
            btn,
            pagination,
        },
        data() {
            return {
                isLoading: false,
                pagination: {},
                filters: {
                    product: "",
                },
                datas: {
                    line: null,
                    products: [],
                }
            }
        },
        created() {
            this.fetchProducts();
            this.searchProductsForAutocomplete();
        },
        computed: {
            ...mapGetters({
                allProducts: 'products/allProducts',
            }),
        },
        methods: {
            beforeOpen(event) {
                this.line = event.params.line;
            },
            hide() {
                this.$modal.hide('search-products');
            },
            fetchProducts(pageNumber) {
                this.isLoading = true;

                let pageUrlBase = "/api/auth/settings/item/products/paginate?page=";
                pageNumber = pageNumber || 1;
                let pageURL = pageUrlBase + pageNumber;

                this.$store.dispatch("products/paginate", {
                    url: pageURL,
                    filters: this.filters
                }).then(() => {
                    this.makePagination(this.allProducts.meta, this.allProducts.links);
                }).catch(error => {
                    this.isLoading = false;
                    // this.$swal({
                    //     position: 'top-end',
                    //     icon: 'error',
                    //     title: 'Oops...',
                    //     text: 'Un problème est survenu pour charger les articles',
                    //     showClass: {
                    //         popup: 'animated slideInUp faster'
                    //     },
                    //     hideClass: {
                    //         popup: 'animated slideOutRight faster'
                    //     },
                    //     timer: 5000,
                    //     timerProgressBar: true,
                    // });
                });
            },
            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page: links.next,
                    previous_page: links.previous,
                    total: meta.total,
                };

                this.pagination = pagination;
                this.isLoading = false;
            },
            searchProductsForAutocomplete() {
                this.datas.products = [];
                this.$store.dispatch("products/search", {
                    queryString: this.filters.product,
                }).then(response => {
                    this.datas.products = response;
                }).catch(error => {
                    console.log(error.response);
                });
            },
            setSelection(row) {
                let selection = {
                    line: this.line,
                    row
                };
                this.$emit('selection', selection);
                this.hide();
            }
        }
    }
</script>
