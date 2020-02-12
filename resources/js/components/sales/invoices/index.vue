<template>
    <container :isLoading="isLoading">
        <div slot="content">
            <hero :illustration="`index.svg`">
                <h1 slot="title">Factures</h1>
                <div slot="action">
                    <cta :label="`Créer`"
                         :path="`invoices.create`"></cta>
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
                                :to="{ name: 'invoices.edit', params: { id: row.id } }"
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

                        <btnLink :target="`_blank`"
                             :path="`/api/auth/sales/invoices/`+JSON.stringify(this.checkedInvoices)+`/pdf`"
                             :label="`Imprimer`"
                             :icon="`icon-printer`">
                        </btnLink>

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
                        <formInput :type="`number`"
                                   :id="`invoiceNumber`"
                                   :label="`Numéro de facture`"
                                   :required="false"
                                   v-model="filters.invoiceNumber"
                        >
                        </formInput>

                        <date-picker v-model="filters.invoiceDate"
                                     lang="en"
                                     range
                                     clearable
                                     :shortcuts="shortcuts"
                                     data-title="Date de facturation"
                                     placeholder="Date de facturation"
                                     confirm
                                     value-type="YYYY-MM-DD"
                                     format="DD/MM/YYYY"
                                     input-class="field" />

                        <date-picker v-model="filters.dueDate"
                                     lang="en"
                                     type="date"
                                     value-type="YYYY-MM-DD"
                                     format="DD/MM/YYYY"
                                     data-title="Date d'échéance"
                                     placeholder="Date d'échéance"
                                     input-class="field" />

                        <autocomplete :items="customers"
                                      :isAsync="true"
                                      :label="`Client`"
                                      :focus="false"
                                      :required="false"
                                      v-on:search="searchCustomersForAutocomplete"
                                      v-on:input="setCustomerName"
                        />

                        <formInput :type="`select`"
                                   :id="`status`"
                                   :label="`Statut`"
                                   :items="statuses"
                                   :required="false"
                                   v-model="filters.status"
                                   :disabledChoose="false"
                        >
                        </formInput>

                        <formInput :type="`select`"
                                   :id="`exported`"
                                   :label="`Exporté`"
                                   :items="exports"
                                   :required="false"
                                   v-model="filters.exported"
                                   :disabledChoose="false"
                        >
                        </formInput>

                        <hr class="line-break" />

                        <formInput :type="`number`"
                                   :id="`orderNumber`"
                                   :label="`Numéro de commande`"
                                   :required="false"
                                   v-model="filters.orderNumber"
                        >
                        </formInput>


                        <formInput :type="`number`"
                                   :id="`deliveryNumber`"
                                   :label="`Numéro de BL`"
                                   :required="false"
                                   v-model="filters.deliveryNumber"
                        >
                        </formInput>

                        <cta :label="`Rechercher`"
                             v-on:click="fetchInvoices"
                        ></cta>
                    </fieldset>
                </form>
            </section>
        </div>
    </container>
</template>

<script>
    import { mapGetters } from 'vuex';
    import moment from 'moment';

    import container from '../../layout/container';
    import hero from '../../layout/hero';
    import cta from '../../elements/cta';
    import btn from '../../elements/button';
    import btnLink from '../../elements/link';
    import tag from '../../elements/tag';
    import pagination from '../../elements/pagination';
    import formInput from '../../form/input';
    import autocomplete from '../../form/autocomplete';
    import DatePicker from 'vue2-datepicker';

    export default {
        components: {
            container,
            hero,
            cta,
            btn,
            btnLink,
            tag,
            pagination,
            formInput,
            autocomplete,
            DatePicker,
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
                customers: []
            }
        },
        created() {
            this.isLoading = true;
            this.fetchInvoices();
        },
        computed: {
            ...mapGetters({
                allInvoices: 'invoices/allInvoices',
            }),
        },
        methods: {
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
                console.log("fetchInvoices");
                console.log("this.filters");
                console.log(this.filters);
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

                console.log("allInvoices");
                console.log(this.allInvoices.data);

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
            searchCustomersForAutocomplete(query) {
                console.log("searchCustomersForAutocomplete");
                console.log(query);
                this.customers = [];
                this.filters.customer = query.toUpperCase();
                if (query.length > 2) {
                    this.$store.dispatch("invoices/searchCustomersForAutocomplete", {
                        queryString: query,
                    }).then(response => {
                        console.log(response);
                        this.customers = response.data;
                        console.log(this.customers);
                    }).catch(error => {
                        console.log(error.response);
                    });
                }
            },
            setCustomerName(value) {
                console.log(value);
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
                        title: 'Oops',
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
