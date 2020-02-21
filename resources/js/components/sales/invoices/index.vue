<template>
    <container :isLoading="isLoading">
        <div slot="content">
            <hero :illustration="`index.svg`">
                <h1 slot="title">Factures</h1>
                <div slot="action">
                    <btn type="cta"
                         label="Créer"
                         v-on:click="pathToCreate" />
                </div>
            </hero>

            <div v-if="allInvoices.data">
                <div class="container-table">
                    <table class="wrap-table">
                        <thead class="table-header">
                            <tr class="table-row">
                                <th scope="col" class="table-cell checkAll" @click="checkAll">
                                    <i class="icon-check-circle text-2xl"></i>
                                </th>
                                <th scope="col" class="table-cell">Création</th>
                                <th scope="col" class="table-cell">Numéro</th>
                                <th scope="col" class="table-cell">Client</th>
                                <th scope="col" class="table-cell">Total HT</th>
                                <th scope="col" class="table-cell">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            <tr v-for="(row, index) in allInvoices.data"
                                :key="index"
                                class="table-row"
                            >
                                <td class="table-cell checkbox" data-title="">
                                        <input type="checkbox"
                                               :id="'check' + index"
                                               :name="'check' + index"
                                               :value="row.id"
                                               v-model="checkedInvoices" />
                                        <label :for="'check' + index">
                                            <span><!-- This span is needed to create the "checkbox" element --></span>
                                        </label>
                                </td>
                                <router-link :to="{ name: 'invoices.edit', params: { id: row.id } }"
                                             tag="td"
                                             class="table-cell cursor-pointer"
                                             data-title="Création">
                                    <time :datetime="row.invoice_date">{{ displayDate(row.invoice_date) }}</time>
                                </router-link>
                                <router-link :to="{ name: 'invoices.edit', params: { id: row.id } }"
                                             tag="td"
                                             class="table-cell cursor-pointer"
                                             data-title="Numéro">
                                    {{ row.invoice_no }}
                                </router-link>
                                <router-link :to="{ name: 'invoices.edit', params: { id: row.id } }"
                                             tag="td"
                                             class="table-cell cursor-pointer"
                                             data-title="Client">
                                    <span class="text-purple2 tracking-widest uppercase mr-2">
                                        [{{ row.third_alias }}]
                                    </span>
                                    {{ row.third_name }}
                                </router-link>
                                <router-link :to="{ name: 'invoices.edit', params: { id: row.id } }"
                                             tag="td"
                                             class="table-cell cursor-pointer"
                                             data-title="Total HT">
                                    {{ row.total }}
                                </router-link>
                                <router-link :to="{ name: 'invoices.edit', params: { id: row.id } }"
                                             tag="td"
                                             class="table-cell cursor-pointer"
                                             data-title="Statut">
                                    <tag :label="row.invoice_status"
                                         :color="defineColorTag(row.invoice_status)"
                                    />
                                </router-link>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <pagination :pagination="pagination" v-on:pagechanged="fetchInvoices"></pagination>
            </div>
            <div v-else>
                <img :src="'/assets/img/empty_no_data.svg'"
                     alt="No date for the moment" class="max-w-sm sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl mx-auto" />
            </div>
        </div>

        <div slot="sidebar">
            <section>
                <transition name="slide-right"
                            mode="out-in"
                            @beforeLeave="beforeLeave"
                            @enter="enter"
                            @afterEnter="afterEnter">
                    <fieldset class="fieldset" v-if="checkedInvoices.length">
                        <legend class="legend">Actions</legend>

                        <btn type="link"
                             :target="`_blank`"
                             :path="`/api/auth/sales/invoices/`+JSON.stringify(this.checkedInvoices)+`/pdf`"
                             :label="`Imprimer`"
                             :icon="`icon-printer`">
                        </btn>

                        <btn type="button"
                             :label="`Facturer`"
                             :icon="`icon-edit`"
                             v-on:click="editStatusInvoices"
                        >
                        </btn>
                    </fieldset>
                </transition>

                <form>
                    <fieldset class="fieldset">
                        <legend class="legend">Filtres</legend>
                        <field
                            :type="`number`"
                            :id="`invoiceNumber`"
                            :label="`Numéro de facture`"
                            :required="false"
                            v-model="filters.invoiceNumber"
                        />

                        <date-picker
                            v-model="filters.invoiceDate"
                            lang="en"
                            range
                            clearable
                            :shortcuts="shortcuts"
                            data-title="Date de facturation"
                            placeholder="Date de facturation"
                            confirm
                            value-type="YYYY-MM-DD"
                            format="DD/MM/YYYY"
                            input-class="field"
                        />

                        <date-picker
                            v-model="filters.dueDate"
                            lang="en"
                            type="date"
                            value-type="YYYY-MM-DD"
                            format="DD/MM/YYYY"
                            data-title="Date d'échéance"
                            placeholder="Date d'échéance"
                            input-class="field"
                        />

                        <autocomplete
                            id="customers"
                            :suggestions="customers"
                            label="Client"
                            v-model="filters.customer"
                            :isAsync="true"
                            :focus="false"
                            :required="false"
                            :searchMore="true"
                            v-on:search="searchCustomersForAutocomplete"
                            v-on:searchForMore="show"
                        />

                        <field
                            :type="`select`"
                            :id="`status`"
                            :label="`Statut`"
                            :items="statuses"
                            :required="false"
                            v-model="filters.status"
                            :disabledChoose="false"
                        />

                        <field
                            :type="`select`"
                            :id="`exported`"
                            :label="`Exporté`"
                            :items="exports"
                            :required="false"
                            v-model="filters.exported"
                            :disabledChoose="false"
                        />

                        <hr class="line-break" />

                        <field
                            :type="`number`"
                            :id="`orderNumber`"
                            :label="`Numéro de commande`"
                            :required="false"
                            v-model="filters.orderNumber"
                        />


                        <field
                            :type="`number`"
                            :id="`deliveryNumber`"
                            :label="`Numéro de BL`"
                            :required="false"
                            v-model="filters.deliveryNumber"
                        />

                        <btn type="cta"
                             label="Rechercher"
                             v-on:click="fetchInvoices" />
                    </fieldset>
                </form>
            </section>
            <searchCustomer v-on:selection="setCustomerName" />
        </div>
    </container>
</template>

<script>
    import { mapGetters } from 'vuex';
    import moment from 'moment';

    import container from '../../layout/container';
    import hero from '../../layout/hero';
    import btn from '../../elements/button';
    import tag from '../../elements/tag';
    import pagination from '../../elements/pagination';
    import field from '../../elements/field';
    import autocomplete from '../../form/autocomplete';
    import DatePicker from 'vue2-datepicker';
    import searchCustomer from '../../settings/third/customers/search';

    export default {
        components: {
            container,
            hero,
            btn,
            tag,
            pagination,
            field,
            autocomplete,
            DatePicker,
            searchCustomer,
        },
        data() {
            return {
                isLoading: false,
                prevHeight: 0,
                isCheckAll: false,
                checkedInvoices: [],
                pagination: {},
                shortcuts: [
                    {
                        text: 'Today',
                        onClick: () => {
                            this.filters.invoiceDate = [ new Date(), new Date()]
                        }
                    }
                ],
                statuses: [
                    { id: "draft", name: "Saisie" },
                    { id: "edited", name: "Editée" },
                    { id: "payed", name: "Payée" },
                ],
                exports: [
                    { id: "true", name: "Oui" },
                    { id: "false", name: "Non" },
                ],
                filters: {
                    invoiceNumber: "",
                    invoiceDate: "",
                    dueDate: "",
                    customer: "",
                    status: "",
                    exported: "",
                    orderNumber: "",
                    deliveryNumber: "",
                },
                customers: [],
            }
        },
        created() {
            if (this.payments.length < 1) {
                this.isLoading = true;
                this.$store.dispatch("payments/fetchPayments", {
                    url: '/api/auth/settings/accounting/payments',
                }).then(() => {
                    this.isLoading = false;
                }).catch(error => {
                    this.isLoading = false;
                    this.$swal({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Oups, un problème est survenu pour charger les modes de règlement',
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
            }

            if (this.settlements.length < 1) {
                this.isLoading = true;
                this.$store.dispatch("settlements/fetchSettlements", {
                    url: '/api/auth/settings/accounting/settlements',
                }).then(() => {
                    this.isLoading = false;
                }).catch(error => {
                    this.isLoading = false;
                    this.$swal({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Oups, un problème est survenu pour charger les conditions de règlement',
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
            }

            if (this.salespersons.length < 1) {
                this.isLoading = true;
                this.$store.dispatch("users/fetchUsers", {
                    url: '/api/auth/settings/company/users',
                }).then(() => {
                    this.isLoading = false;
                }).catch(error => {
                    this.$swal({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Oups, un problème est survenu pour charger les commerciaux',
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
            }

            if (this.vats.length < 1) {
                this.isLoading = true;
                this.$store.dispatch("vats/fetchVats", {
                    url: '/api/auth/settings/accounting/vats',
                }).then(() => {
                    this.isLoading = false;
                }).catch(error => {
                    this.$swal({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Oups, un problème est survenu pour charger les taux de TVA',
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
            }


            this.searchCustomersForAutocomplete();
            this.fetchInvoices();
        },
        computed: {
            ...mapGetters({
                allInvoices: 'invoices/allInvoices',
                payments: 'payments/allPayments',
                settlements: 'settlements/allSettlements',
                salespersons: 'users/salespersons',
                vats: 'vats/allVats',
            }),
        },
        methods: {
            pathToCreate() {
                this.$router.push({ name: 'invoices.create' })
            },
            beforeLeave(element) {
                this.prevHeight = getComputedStyle(element).height;
            },
            enter(element) {
                const { height } = getComputedStyle(element);

                element.style.height = this.prevHeight;

                setTimeout(() => {
                    element.style.height = height;
                });
            },
            afterEnter(element) {
                element.style.height = 'auto';
            },
            checkAll() {
                this.isCheckAll = !this.isCheckAll;
                this.checkedInvoices = [];
                if (this.isCheckAll) { // Check all
                    for (var key in this.allInvoices.data) {
                        this.checkedInvoices.push(this.allInvoices.data[key].id);
                    }
                }
            },
            fetchInvoices(pageNumber) {
                this.isLoading = true;

                let pageUrlBase = "/api/auth/sales/invoices/filtered?page=";
                pageNumber = pageNumber || 1;
                let pageURL = pageUrlBase + pageNumber;

                this.$store.dispatch("invoices/index", {
                    url: pageURL,
                    filters: this.filters
                }).then(() => {
                    this.makePagination(this.allInvoices.meta, this.allInvoices.links);
                }).catch(error => {
                    this.isLoading = false;
                    this.$swal({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Un problème est survenu pour charger les factures',
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
            displayDate(date) {
                return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
            },
            defineColorTag(status) {
                if (status === "draft") {
                    return "yellow";
                } else if (status === "edited") {
                    return "red";
                } else {
                    return "purple";
                }
            },
            show() {
                this.$modal.show('search-customers');
            },
            searchCustomersForAutocomplete() {
                this.customers = [];
                this.$store.dispatch("invoices/searchCustomers", {
                    queryString: this.filters.customer,
                }).then(response => {
                    this.customers = response.data;
                }).catch(error => {
                    console.log(error.response);
                });
            },
            setCustomerName(value) {
                this.filters.customer = value.name;
            },
            editStatusInvoices() {
                this.$store.dispatch("invoices/editStatus", {
                    invoices: this.checkedInvoices,
                    filters: this.filters
                }).then(response => {

                }).catch(error => {
                    this.$swal({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Un problème est survenu pour modifier les factures',
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
            }
        }
    }
</script>

<style lang="scss" scoped>
    .checkAll {
        cursor: pointer;
        transition: all .4s;

        &:hover {
            > * {
                color: theme('colors.yellow1');
            }
        }
    }
</style>
