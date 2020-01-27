<template>
    <form>
        <fieldset class="fieldset">
            <formInput :type="`text`"
                       :id="`name`"
                       :label="`Référence`"
                       :required="false"
                       :value="form.header.name" />

            <div class="container-table">
                <table class="wrap-table">
                    <thead class="table-header">
                    <tr class="table-row">
                        <th scope="col" class="table-cell">Description</th>
                        <th scope="col" class="table-cell">TVA</th>
                        <th scope="col" class="table-cell">Quantité</th>
                        <th scope="col" class="table-cell">Remise</th>
                        <th scope="col" class="table-cell">PU</th>
                        <th scope="col" class="table-cell">Total HT</th>
                        <th scope="col" class="table-cell"> </th>
                    </tr>
                    </thead>
                    <tbody class="table-body">
                    <tr v-for="(line, index) in form.body.lines"
                        :key="index"
                        class="table-row"
                    >
                        <td class="table-cell" data-title="Description">
                            <formInput :type="`textarea`"
                                       :id="`description` + index"
                                       :label="`Description`"
                                       :required="false"
                                       v-on:input="form.body.lines[index].description" />
                        </td>
                        <td class="table-cell" data-title="TVA">
                            <formInput v-if="form.body.lines[index].invoice_line_type != 'comment'"
                                       :type="`select`" class="mt-6"
                                       :id="`vat_id` + index"
                                       :label="`TVA`"
                                       :items="[{id:'toto', name:'toto'}, {id:'tata', name:'tata'}, {id:'titi', name:'titi'}]"
                                       :required="false"
                                       v-on:input="form.body.lines[index].vat_id" />
                        </td>
                        <td class="table-cell" data-title="Quantité">
                            <formInput v-if="form.body.lines[index].invoice_line_type != 'comment'"
                                       :type="`number`"
                                       :id="`quantity` + index"
                                       :label="`Quantité`"
                                       :required="false"
                                       v-on:input="form.body.lines[index].quantity" />
                        </td>
                        <td class="table-cell" data-title="Remise">
                            <formInput v-if="form.body.lines[index].invoice_line_type != 'comment'"
                                       :type="`number`"
                                       :id="`discount_rate` + index"
                                       :label="`Remise`"
                                       :required="false"
                                       v-on:input="form.body.lines[index].discount_rate" />
                        </td>
                        <td class="table-cell" data-title="PU">
                            <formInput v-if="form.body.lines[index].invoice_line_type != 'comment'"
                                       :type="`number`"
                                       :id="`unit_price` + index"
                                       :label="`PU`"
                                       :required="false"
                                       v-on:input="form.body.lines[index].unit_price" />
                        </td>
                        <td class="table-cell" data-title="Total HT">
                            <formInput v-if="form.body.lines[index].invoice_line_type != 'comment'"
                                       :type="`number`"
                                       :id="`total_amount` + index"
                                       :label="`Total HT`"
                                       :required="false"
                                       v-on:input="form.body.lines[index].total_amount" />
                        </td>
                        <td class="table-cell" style="width: 4.25rem" data-title="" @click="deleteLine(index)">
                            <i class="icon-x-circle text-red1 text-xl"></i>
                        </td>
                    </tr>
                    </tbody>
                </table>
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
            deleteLine(lineIndex) {
                this.form.body.lines.splice(lineIndex);
            }
        }
    }
</script>
