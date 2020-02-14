<template>
    <modal name="search-customers" :adaptive="true" :width="1180" :height="710">
        <loader v-if="isLoading"></loader>
        <div class="modal-container">
            <div class="modal-header">
                <h3 class="modal-title">Rechercher un client</h3>
                <button type="button"
                        class="modal-close"
                        aria-label="Fermer la fenêtre modale"
                        @click="hide">
                </button>

                <form action="#" method="post" class="form-filters">
                    <div class="flex">
                        <autocomplete
                            id="customers"
                            :suggestions="datas.customers"
                            label="Client"
                            v-model="filters.customer"
                            :isAsync="true"
                            :focus="false"
                            :required="false"
                            v-on:search="searchCustomersForAutocomplete"
                        />

                        <autocomplete
                            id="contacts"
                            :suggestions="datas.contacts"
                            label="Contact"
                            v-model="filters.contact"
                            :isAsync="true"
                            :focus="false"
                            :required="false"
                            v-on:search="searchContactsForAutocomplete"
                        />
                    </div>

                    <div class="flex">
                        <field
                            type="number"
                            :id="'postcode'"
                            v-model=filters.postcode
                            :label="'Département/Code postal'"
                            :rules="'min:2|max:10'"
                        />

                        <field
                            type="select"
                            :id="'salesperson'"
                            :label="'Commercial'"
                            :items="salespersons"
                            v-model="filters.salesperson"
                            :disabledChoose="false"
                            :rules="'integer'"
                       />
                    </div>

                    <btn type="button" class="modal-submit"
                         label="Rechercher"
                         icon="icon-search"
                         v-on:click="fetchCustomers()"
                    />

                </form>
            </div>

            <div class="modal-body">
                <div v-if="allCustomers.data.length || Object.keys(allCustomers.data.length).length">
                    <div class="container-table">
                        <table class="wrap-table">
                            <thead class="table-header">
                                <tr class="table-row">
                                    <th scope="col" class="table-cell">Logotype</th>
                                    <th scope="col" class="table-cell">Raison sociale</th>
                                    <th scope="col" class="table-cell">Contact</th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                <tr v-for="(row, index) in allCustomers.data"
                                    :key="index"
                                    class="table-row"
                                    @click="setSelection(row)"
                                >
                                    <td class="table-cell cursor-pointer"
                                        data-title="">
                                        <img class="max-w-xs h-16"
                                             :src="'/assets/img/logos/' + row.logo"
                                             alt="En attente d'une recherche"/>
                                    </td>
                                    <td class="table-cell cursor-pointer"
                                        data-title="Raison sociale">
                                        <span class="text-purple2 tracking-widest uppercase mr-2">
                                            [{{ row.alias }}]
                                        </span>
                                        {{ row.name }}
                                    </td>
                                    <td class="table-cell cursor-pointer"
                                        data-title="Contact">
                                        {{ row.contacts[0] ? row.contacts[0].name : '' }} {{ row.contacts[0] ? row.contacts[0].lastname : '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <pagination :pagination="pagination" v-on:pagechanged="fetchCustomers"></pagination>
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
                    customer: "",
                    contact: "",
                    postcode: "",
                    salesperson: "",
                },
                datas: {
                    customers: [],
                    contacts: [],
                }
            }
        },
        created() {
            this.fetchCustomers();
            this.searchCustomersForAutocomplete();
            this.searchContactsForAutocomplete();
            this.$store.dispatch("users/fetchUsers", {
                url: '/api/auth/settings/company/users',
            });
        },
        computed: {
            ...mapGetters({
                allCustomers: 'customers/allCustomers',
                salespersons: 'users/salespersons',
            }),
        },
        methods: {
            hide() {
                this.$modal.hide('search-customers');
            },
            fetchCustomers(pageNumber) {
                this.isLoading = true;

                let pageUrlBase = "/api/auth/settings/third/customers/paginate?page=";
                pageNumber = pageNumber || 1;
                let pageURL = pageUrlBase + pageNumber;

                this.$store.dispatch("customers/paginate", {
                    url: pageURL,
                    filters: this.filters
                }).then(() => {
                    this.makePagination(this.allCustomers.meta, this.allCustomers.links);
                }).catch(error => {
                    this.isLoading = false;
                    this.$swal({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Un problème est survenu pour charger les clients',
                        showClass: {
                            popup: 'animated slideInUp faster'
                        },
                        hideClass: {
                            popup: 'animated slideOutRight faster'
                        },
                        timer: 5000,
                        timerProgressBar: true,
                    });
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
            searchCustomersForAutocomplete() {
                this.datas.customers = [];
                this.$store.dispatch("customers/search", {
                    queryString: this.filters.customer,
                }).then(response => {
                    this.datas.customers = response;
                }).catch(error => {
                    console.log(error.response);
                });
            },
            searchContactsForAutocomplete() {
                this.datas.contacts = [];
                this.$store.dispatch("customers/searchContacts", {
                    queryString: this.filters.contact,
                }).then(response => {
                    this.datas.contacts = response;
                }).catch(error => {
                    console.log(error.response);
                });
            },
            setSelection(row) {
                this.$emit('selection', row);
                this.hide();
            }
        }
    }
</script>
