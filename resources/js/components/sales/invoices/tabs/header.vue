<template>
    <div>
        <fieldset class="fieldset">
            <field
                :type="`text`"
                :id="`name`"
                v-model="invoice[0].name"
                label="Référence"
                :readonly="invoice[0].invoice_status === 'draft' ? false : true"
            />

            <div class="flex flex-wrap items-start mt-8 sm:flex-no-wrap md:flex-wrap lg:flex-no-wrap">
                <div class="w-full mr-12">
                    <div class="flex justify-between items-center w-full pb-4 border-b border-solid border-grey">
                        <h3 class="mr-4 text-lg font-black tracking-wide">Client</h3>
                        <autocomplete
                            v-if="invoice[0].invoice_status === 'draft'"
                            class="field-is-small"
                            id="customers"
                            :suggestions="datas.customers"
                            label="Client"
                            v-model="filters.customer"
                            :isAsync="true"
                            :focus="false"
                            :required="false"
                            :searchMore="true"
                            v-on:search="searchCustomersForAutocomplete"
                            @setResult="setCustomer"
                            v-on:searchForMore="show"
                        />
                        <button
                            v-if="invoice[0].invoice_status === 'draft'"
                            type="button"
                            @click.stop.prevent="resetCustomer"
                            aria-label="Réinitialiser"
                            title="Réinitialiser"
                            class="ml-4 text-lg text-purple1">
                            <i class="icon-refresh-cw"></i>
                        </button>
                    </div>
                    <div class="flex mt-6">
                        <field
                            :type="`number`"
                            id="third_id"
                            v-model="invoice[0].third_id"
                            label="Compte"
                            :disabled="true"
                        />

                        <field
                            :type="`text`"
                            id="third_alias"
                            label="Abrégé"
                            v-model="invoice[0].third_alias"
                            :disabled="true"
                        />
                    </div>

                    <field
                        :type="`text`"
                        id="third_name"
                        label="Raison sociale"
                        v-model="invoice[0].third_name"
                        :required="true"
                        :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                    />

<!--                    <field-->
<!--                        v-if="datas.addresses.length"-->
<!--                        :type="`select`"-->
<!--                        id="addresses"-->
<!--                        v-model="datas.customer_address"-->
<!--                        label="Adresse de facturation"-->
<!--                        :items="datas.addresses"-->
<!--                        :readonly="invoice[0].invoice_status === 'draft' ? false : true"-->
<!--                    />-->

                    <div v-if="datas.customer_address === ''">
                        <field
                            :type="`text`"
                            id="third_address_line1"
                            v-model="invoice[0].third_address_line1"
                            label="Numéro + Libellé de la voie"
                            :required="true"
                            :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                        />

                        <field
                            :type="`text`"
                            id="third_address_line2"
                            v-model="invoice[0].third_address_line2"
                            label="Complément de localisation"
                            :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                        />

                        <field
                            :type="`text`"
                            id="third_address_line3"
                            v-model="invoice[0].third_address_line3"
                            label="BP - Lieu dit"
                            :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                        />

                        <div class="flex">
                            <field
                                :type="`text`"
                                id="third_postcode"
                                v-model="invoice[0].third_postcode"
                                label="Code postal"
                                :required="true"
                                :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                            />

                            <field
                                :type="`text`"
                                id="third_city"
                                v-model="invoice[0].third_city"
                                label="Ville"
                                :required="true"
                                :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                            />
                        </div>
                    </div>

                    <field
                        :type="`text`"
                        id="third_intracommunity_no"
                        v-model="invoice[0].third_intracommunity_no"
                        label="TVA intracommunautaire"
                        :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                    />

                </div>
                <div class="w-full mt-8 sm:mt-0 md:mt-8 lg:mt-0">
                    <div class="flex items-center w-full mb-6 pb-4 border-b border-solid border-grey" :style="invoice[0].invoice_status === 'draft' ? 'height: 4.6rem;' : ''">
                        <h3 class="text-lg font-black tracking-wide">Commercial</h3>
                    </div>
                    <field
                        :type="`select`"
                        id="user_id"
                        v-model="invoice[0].user_id"
                        label="Commercial en charge"
                        :items="salespersons"
                        :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                    />

                    <field
                        :type="`number`"
                        id="user_commission_base"
                        v-model="invoice[0].user_commission_base"
                        label="Base de commission"
                        :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                    />

                    <field
                        :type="`number`"
                        id="user_commission_rate"
                        v-model="invoice[0].user_commission_rate"
                        label="Taux de commission"
                        @input="setUserCommissionAmount(index)"
                        :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                    />

                    <field
                        :type="`number`"
                        id="user_commission_amount"
                        v-model="invoice[0].user_commission_amount"
                        label="Montant de commission"
                        :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                    />

                    <field
                        :type="`number`"
                        id="discount_rate"
                        label="Taux de remise"
                        v-model="invoice[0].discount_rate"
                        :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                    />

                    <field
                        :type="`number`"
                        id="bank_rate"
                        v-model="invoice[0].bank_rate"
                        label="Taux d'escompte"
                        :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                    />

                    <field
                        :type="`number`"
                        id="discount_duration"
                        v-model="invoice[0].discount_duration"
                        label="Durée de l'escompte"
                        :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                    />
                </div>
            </div>
        </fieldset>

        <searchCustomer v-on:selection="setCustomer" />
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import { mapMultiRowFields } from 'vuex-map-fields';
    import field from "../../../elements/field";
    import autocomplete from '../../../form/autocomplete';
    import DatePicker from 'vue2-datepicker';
    import searchCustomer from '../../../settings/third/customers/search';

    export default {
        components: {
            field,
            autocomplete,
            DatePicker,
            searchCustomer,
        },
        data() {
            return {
                filters: {
                    customer: ""
                },
                datas: {
                    customers: [],
                    customer_address: "",
                    addresses: []
                }
            }
        },
        created() {
            this.searchCustomersForAutocomplete();
        },
        computed: {
            ...mapMultiRowFields('invoices', ['invoice']),

            ...mapGetters({
                salespersons: 'users/salespersons',
            }),
        },
        methods: {
            notBeforeToday(date) {
                return date < new Date();
            },
            show() {
                this.$modal.show('search-customers');
            },
            searchCustomersForAutocomplete(query) {
                this.datas.customers = [];
                this.$store.dispatch("customers/search", {
                    queryString: this.filters.customer,
                }).then(response => {
                    this.datas.customers = response;
                }).catch(error => {
                    console.log(error.response);
                });
            },
            setCustomer(value) {
                this.filters.customer = value.name;
                this.invoice[0].third_id = value.id;
                this.invoice[0].third_alias = value.alias;
                this.invoice[0].third_name = value.name;

                // this.datas.addresses = value.addresses;

                this.invoice[0].third_address_line1 = value.address_line1;
                this.invoice[0].third_address_line2 = value.address_line2;
                this.invoice[0].third_address_line3 = value.address_line3;
                this.invoice[0].third_postcode = value.postcode;
                this.invoice[0].third_city = value.city;

                this.invoice[0].third_intracommunity_no = value.intracommunity_no;
                this.invoice[0].user_id = value.user_id;
                this.invoice[0].user_commission_rate = value.commission_rate;
                this.invoice[0].discount_rate = value.discount_rate;
                this.invoice[0].bank_rate = value.bank_rate;
                this.invoice[0].discount_duration = value.discount_duration;


                this.invoice[0].user_commission_base = this.invoice[0].total_pretax;
                this.invoice[0].user_commission_amount = (parseFloat(this.invoice[0].total_pretax) * (parseFloat(this.invoice[0].user_commission_rate) / 100)).toFixed(2);
            },
            resetCustomer() {
                this.filters.customer = "";
                this.invoice[0].third_id = "";
                this.invoice[0].third_alias = "";
                this.invoice[0].third_name = "";
                this.datas.addresses = [];
                this.datas.customer_address = "";
                this.invoice[0].third_address_line1 = "";
                this.invoice[0].third_address_line2 = "";
                this.invoice[0].third_address_line3 = "";
                this.invoice[0].third_postcode = "";
                this.invoice[0].third_city = "";
                this.invoice[0].third_intracommunity_no = "";
                this.invoice[0].user_id = "";
                this.invoice[0].user_commission_base = this.invoice[0].total_pretax;
                this.invoice[0].user_commission_rate = "";
                this.invoice[0].user_commission_amount = "";
                this.invoice[0].discount_rate = "";
                this.invoice[0].bank_rate = "";
                this.invoice[0].discount_duration = "";
            },
            show() {
                this.$modal.show('search-customers');
            },
            setUserCommissionAmount() {
                if (parseFloat(this.invoice[0].user_commission_rate) > 0) {
                    let userCommissionAmount = (parseFloat(this.invoice[0].total_pretax) * (parseFloat(this.invoice[0].user_commission_rate) / 100)).toFixed(2)
                    this.invoice[0].user_commission_amount = parseFloat(userCommissionAmount);
                } else {
                    this.invoice[0].user_commission_amount = 0;
                }
            },
        }
    }
</script>
