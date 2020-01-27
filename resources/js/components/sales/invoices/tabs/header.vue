<template>
    <form>
        <fieldset class="fieldset">
            <formInput :type="`text`"
                       :id="`name`"
                       :label="`Référence`"
                       :required="false"
                       v-model="form.header.name" />

            <div class="flex items-end mt-8">
                <div class="w-full mr-12">
                    <div class="flex justify-between w-full border-b border-solid border-grey">
                        <h3 class="pb-4 text-lg font-black tracking-wide">Client</h3>
                        <btn class="w-12" :label="``"
                             :icon="`icon-search`">
                        </btn>
                    </div>
                    <div class="flex mt-6">
                        <formInput :type="`number`"
                                   :id="`third_id`"
                                   :label="`Compte`"
                                   :required="false"
                                   v-model="form.header.third_id" />

                        <formInput :type="`text`"
                                   :id="`third_alias`"
                                   :label="`Abrégé`"
                                   :required="false"
                                   v-model="form.header.third_alias" />
                    </div>

                    <formInput :type="`text`"
                               :id="`third_name`"
                               :label="`Rausib sociale`"
                               :required="false"
                               v-model="form.header.third_name" />

                    <formInput :type="`text`"
                               :id="`third_address_line1`"
                               :label="`Numéro + Libellé de la voie`"
                               :required="false"
                               v-model="form.header.third_address_line1" />

                    <formInput :type="`text`"
                               :id="`third_address_line2`"
                               :label="`Complément de localisation`"
                               :required="false"
                               v-model="form.header.third_address_line2" />

                    <formInput :type="`text`"
                               :id="`third_address_line3`"
                               :label="`BP - Lieu dit`"
                               :required="false"
                               v-model="form.header.third_address_line3" />

                    <div class="flex">
                        <formInput :type="`text`"
                                   :id="`third_zipcode`"
                                   :label="`Code postal`"
                                   :required="false"
                                   v-model="form.header.third_zipcode" />

                        <formInput :type="`text`"
                                   :id="`city`"
                                   :label="`Ville`"
                                   :required="false"
                                   v-model="form.header.city" />
                    </div>

                    <formInput :type="`text`"
                               :id="`third_intracommunity_no`"
                               :label="`TVA intracommunautaire`"
                               :required="false"
                               v-model="form.header.third_intracommunity_no" />

                </div>
                <div class="w-full">
                    <div class="flex w-full border-b border-solid border-grey">
                        <h3 class="pb-4 text-lg font-black tracking-wide">Commercial</h3>
                    </div>
                    <formInput :type="`select`" class="mt-6"
                               :id="`user_id`"
                               :label="`Commercial en charge`"
                               :items="[{id:'toto', name:'toto'}, {id:'tata', name:'tata'}, {id:'titi', name:'titi'}]"
                               :required="false"
                               v-model="form.header.user_id" />

                    <formInput :type="`number`"
                               :id="`user_commission_base`"
                               :label="`Base de commission`"
                               :required="false"
                               v-model="form.header.user_commission_base" />

                    <formInput :type="`number`"
                               :id="`user_commission_rate`"
                               :label="`Taux de commission`"
                               :required="false"
                               v-model="form.header.user_commission_rate" />

                    <formInput :type="`number`"
                               :id="`user_commission_amount`"
                               :label="`Montant de commission`"
                               :required="false"
                               v-model="form.header.user_commission_amount" />

                    <formInput :type="`number`"
                               :id="`discount_rate`"
                               :label="`Taux de remise`"
                               :required="false"
                               v-model="form.header.discount_rate" />

                    <formInput :type="`number`"
                               :id="`bank_rate`"
                               :label="`Taux d'escompte`"
                               :required="false"
                               v-model="form.header.bank_rate" />

                    <DatePicker v-model="form.header.discount_duration"
                                 lang="en"
                                 type="date"
                                 format="YYYY-MM-dd"
                                 placeholder="Durée de l'escompte"
                                 input-class="field" />
                </div>
            </div>
        </fieldset>
    </form>
</template>

<script>
    import { mapGetters } from 'vuex';
    import formInput from "../../../form/input";
    import btn from '../../../elements/button';
    import DatePicker from 'vue2-datepicker';

    export default {
        components: {
            formInput,
            btn,
            DatePicker,
        },
        data() {
            return {

            }
        },
        computed: {
            ...mapGetters({
                form: 'invoices/formInvoice',
            }),
        },
        methods: {

        }
    }
</script>
