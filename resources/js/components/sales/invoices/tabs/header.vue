<template>
    <div>
        <fieldset class="fieldset">
            <field
                :type="`text`"
                :id="`name`"
                v-model="invoice[0].name"
                label="Référence"
            />

            <div class="flex items-start mt-8">
                <div class="w-full mr-12">
                    <div class="flex justify-between items-center w-full pb-4 border-b border-solid border-grey">
                        <h3 class="mr-4 text-lg font-black tracking-wide">Client</h3>
                        <autocomplete
                            class="field-is-small"
                            id="customers"
                            :suggestions="customers"
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
                        <button type="button"
                                @click.stop.prevent="resetCustomer"
                                aria-label="Réinitialiser"
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
                    />

                    <field
                        :type="`text`"
                        id="third_address_line1"
                        v-model="invoice[0].third_address_line1"
                        label="Numéro + Libellé de la voie"
                        :required="true"
                    />

                    <field
                        :type="`text`"
                        id="third_address_line2"
                        v-model="invoice[0].third_address_line2"
                        label="Complément de localisation"
                    />

                    <field
                        :type="`text`"
                        id="third_address_line3"
                        v-model="invoice[0].third_address_line3"
                        label="BP - Lieu dit"
                    />

                    <div class="flex">
                        <field
                            :type="`text`"
                            id="third_postcode"
                            v-model="invoice[0].third_postcode"
                            label="Code postal"
                            :required="true"
                        />

                        <field
                            :type="`text`"
                            id="third_city"
                            v-model="invoice[0].third_city"
                            label="Ville"
                            :required="true"
                        />
                    </div>

                    <field
                        :type="`text`"
                        id="third_intracommunity_no"
                        v-model="invoice[0].third_intracommunity_no"
                        label="TVA intracommunautaire"
                    />

                </div>
                <div class="w-full">
                    <div class="flex items-center w-full mb-6 pb-4 border-b border-solid border-grey" style="height: 4.6rem;">
                        <h3 class="text-lg font-black tracking-wide">Commercial</h3>
                    </div>
                    <field
                        :type="`select`" class="mt-6"
                        id="user_id"
                        v-model="invoice[0].user_id"
                        label="Commercial en charge"
                        :items="salespersons"
                    />

                    <field
                        :type="`number`"
                        id="user_commission_base"
                        v-model="invoice[0].user_commission_base"
                        label="Base de commission"
                    />

                    <field
                        :type="`number`"
                        id="user_commission_rate"
                        v-model="invoice[0].user_commission_rate"
                        label="Taux de commission"
                    />

                    <field
                        :type="`number`"
                        id="user_commission_amount"
                        v-model="invoice[0].user_commission_amount"
                        label="Montant de commission"
                    />

                    <field :type="`number`"
                               id="discount_rate"
                               label="Taux de remise"
                               v-model="invoice[0].discount_rate" />

                    <field
                        :type="`number`"
                        id="bank_rate"
                        v-model="invoice[0].bank_rate"
                        label="Taux d'escompte"
                    />

                    <field
                        :type="`number`"
                        id="discount_duration"
                        v-model="invoice[0].discount_duration"
                        label="Durée de l'escompte"
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
                customers: []
            }
        },
        created() {
            this.invoice[0].third_name = "test";
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
                this.customers = [];
                this.$store.dispatch("customers/search", {
                    queryString: this.filters.customer,
                }).then(response => {
                    this.customers = response;
                }).catch(error => {
                    console.log(error.response);
                });
            },
            setCustomer(value) {
                console.log("this.invoice[0].third_id");
                console.log(this.invoice[0].third_id);
                console.log("setCustomer");
                console.log(value.id);
                this.filters.customer = value.name;
                this.invoice[0].third_id = value.id;
                console.log("this.invoice[0].third_id");
                console.log(this.invoice[0].third_id);
                this.invoice[0].third_alias = value.alias;
                this.invoice[0].third_name = value.name;
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
            hide() {
                this.$modal.hide('search-customers');
            },
            opened() {
                // if (this.database.printing.substrates.search.criteria.types.length < 1) {
                //     this.getSubstratesSearchCriteria();
                // }
            },
            save() {

            },
        }
    }
</script>
