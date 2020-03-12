<template>
    <div>
        <fieldset class="fieldset">
            <field
                :type="`text`"
                :id="`name`"
                :label="`Référence`"
                :required="false"
                :value="invoice[0].name"
                :readonly="invoice[0].invoice_status === 'draft' ? false : true"
            />

            <div class="container-table has-border">
                <table class="wrap-table">
                    <thead class="table-header">
                    <tr class="table-row">
                        <th scope="col" class="table-cell">Description</th>
                        <th scope="col" class="table-cell">TVA</th>
                        <th scope="col" class="table-cell">Quantité</th>
                        <th scope="col" class="table-cell">Prix unitaire</th>
                        <th scope="col" class="table-cell">Réduction</th>
                        <th scope="col" class="table-cell">Total HT</th>
                        <th scope="col" class="table-cell"> </th>
                    </tr>
                    </thead>
                    <tbody class="table-body">
                    <tr v-for="(line, index) in lines"
                        :key="index"
                        class="table-row fields-are-small"
                    >
                        <td class="table-cell visible-title" :data-title="line.type === 'product' ? 'Article' : 'Commentaire'" :colspan="line.type === 'comment' ? 6 : 0">
                            <autocomplete
                                v-if="line.type === 'product'"
                                :id="`name` + index"
                                :suggestions="products"
                                label="Description"
                                v-model="line.name"
                                :isAsync="true"
                                :focus="line.id !== '' ? false : true"
                                :required="true"
                                :searchMore="true"
                                :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                                @search="(...args)=>searchProductsForAutocomplete(index,...args)"
                                @setResult="(...args)=>selectedProduct(index,...args)"
                                @searchForMore="show(index)"
                                @focusOut="(...args)=>handleBlur(index,...args)"
                            />
                            <field
                                :type="`textarea`"
                                :id="`description` + index"
                                v-model="line.description"
                                label="Description"
                                :required="line.type === 'product' ? false : true"
                                :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                            />
                        </td>
                        <td class="table-cell visible-title" data-title="TVA" v-if="line.type != 'comment'">
                            <field
                                :type="`select`"
                                :id="`vat_id` + index"
                                v-model="line.vat_id"
                                label="TVA"
                                :choose="false"
                                :required="true"
                                :items="vats"
                                :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                            />
                        </td>
                        <td class="table-cell visible-title" data-title="Quantité" v-if="line.type != 'comment'">
                            <field
                                :type="`number`"
                                :id="`quantity` + index"
                                v-model="line.quantity"
                                label="Quantité"
                                :required="true"
                                @input="setUnitPrice(index)"
                                :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                            />
                        </td>
                        <td class="table-cell visible-title" data-title="PU" v-if="line.type != 'comment'">
                            <field
                                :type="`number`"
                                :id="`unit_price` + index"
                                v-model="line.unit_price"
                                label="Prix unitaire"
                                :required="false"
                                @input="setLineTotal(index)"
                                :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                            />
                        </td>
                        <td class="table-cell visible-title" data-title="Réduction" v-if="line.type != 'comment'">
                            <field
                                :type="`number`"
                                :id="`discount_rate` + index"
                                v-model="line.discount_rate"
                                label="Réduction"
                                :required="false"
                                @input="setLineTotal(index)"
                                :readonly="invoice[0].invoice_status === 'draft' ? false : true"
                            />
                        </td>
                        <td class="table-cell visible-title" data-title="Total HT" v-if="line.type != 'comment'">
                            <field
                                :type="`number`"
                                :id="`total_amount` + index"
                                v-model="line.total_pretax"
                                label="Total HT"
                                :required="false"
                                :readonly="true"
                                @input="setLineTotal(index)"
                            />
                        </td>
                        <td class="table-cell delete relative" data-title="">
                            <btn :type="'delete'"
                                 v-on:click="alertDisplay(index)"
                            />
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </fieldset>

        <searchProduct v-on:selection="setProduct" />
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import { mapMultiRowFields } from 'vuex-map-fields';

    import field from "../../../elements/field";
    import btn from '../../../elements/button';
    import DatePicker from 'vue2-datepicker';
    import autocomplete from "../../../form/autocomplete";
    import searchProduct from '../../../settings/product/products/search';

    export default {
        components: {
            autocomplete,
            field,
            btn,
            DatePicker,
            searchProduct,
        },
        data() {
            return {
                products: [],
            }
        },
        created() {
            this.searchProductsForAutocomplete();
        },
        computed: {
            ...mapMultiRowFields('invoices', ['invoice', 'lines']),
            ...mapGetters({
                vats: 'vats/allVats',
            }),
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
            searchProductsForAutocomplete(index) {
                let query = "";
                if (index) {
                    query = this.lines[index].name;
                }
                this.$store.dispatch("products/search", {
                    queryString: query
                }).then(response => {
                    this.products = response;
                }).catch(error => {
                    console.log(error.response);
                });
            },
            selectedProduct(index, value) {
                this.lines[index].name = value.name;
                this.lines[index].description = value.description;
                this.lines[index].product_id = value.id;
                this.lines[index].product = value;
                this.setUnitPrice(index);
                this.textareaAutosize();
            },
            show(lineIndex) {
                this.$modal.show('search-products', { line: lineIndex });
            },
            setProduct(value) {
                this.selectedProduct(value.line, value.row);
            },
            handleBlur(index, productSelected) {
                if (!productSelected) {
                    if (this.lines[index].product.id !== undefined) {
                        this.lines[index].name = this.lines[index].product.name;
                    } else {
                        this.$store.commit('invoices/REMOVE_LINE', index);
                    }
                }
            },
            setUnitPrice(index) {
                let product = this.lines[index].product;
                let quantity = parseFloat(this.lines[index].quantity);
                if (product.product_id !== '') {
                    let quantities = product.quantities;
                    let unitPrice = 0;
                    for (let [key, value] of Object.entries(quantities)) {
                        if (quantity >= value.quantity_minimum) {
                            for (let [index, item] of Object.entries(quantities)) {
                                if (quantity <= item.quantity_maximum) {
                                    unitPrice = item.unit_price;
                                    break;
                                }
                            }
                        }
                    }
                    this.lines[index].unit_price = unitPrice;
                    this.setLineTotal(index);
                }
            },
            setLineTotal(index) {
                let unitPrice = parseFloat(this.lines[index].unit_price);
                let quantity = parseFloat(this.lines[index].quantity);
                let discount = parseFloat(this.lines[index].discount_rate);

                let subtotal = parseFloat((quantity * unitPrice).toFixed(2));
                // this.$store.commit('invoices/SET_LINE_SUBTOTAL', subtotal);
                this.lines[index].subtotal = subtotal;

                let discountAmount = parseFloat((subtotal * (discount / 100)).toFixed(2));
                this.lines[index].discount_amount = -Math.abs(discountAmount);

                let total_pretax = parseFloat((subtotal - discountAmount).toFixed(2));
                this.lines[index].total_pretax = total_pretax;

                let vat = this.vats.filter(vat => vat.id === parseInt(this.lines[index].vat_id))[0];
                let amountVat = parseFloat((total_pretax * (vat.rate / 100)).toFixed(2));
                this.lines[index].vat_amount = amountVat;

                let total = parseFloat((total_pretax + amountVat).toFixed(2));
                this.lines[index].total = total;

                this.setInvoicePrices();
            },
            setInvoicePrices() {
                let invoiceSubtotal = 0;
                let invoiceDiscountAmount = 0;
                let invoiceTotalPretax = 0;
                let invoiceVat = 0;
                let invoiceTotal = 0;

                for (let [key, value] of Object.entries(this.lines)) {
                    if (value.type === "product") {
                        invoiceSubtotal += parseFloat(value.subtotal);
                        invoiceDiscountAmount += parseFloat(value.discount_amount);
                        invoiceTotalPretax += parseFloat(value.total_pretax);
                        invoiceVat += parseFloat(value.vat_amount);
                        invoiceTotal += parseFloat(value.total);
                    }
                }

                this.invoice[0].subtotal = invoiceSubtotal.toFixed(2);
                this.invoice[0].discount_amount = invoiceDiscountAmount.toFixed(2);
                this.invoice[0].total_pretax = invoiceTotalPretax.toFixed(2);
                this.invoice[0].vat = invoiceVat.toFixed(2);
                this.invoice[0].total = invoiceTotal.toFixed(2);

                this.invoice[0].user_commission_base = invoiceTotalPretax.toFixed(2);
                if (parseFloat(this.invoice[0].user_commission_rate) > 0) {
                    let userCommissionAmount = (parseFloat(this.invoice[0].total_pretax) * (parseFloat(this.invoice[0].user_commission_rate) / 100)).toFixed(2)
                    this.invoice[0].user_commission_amount = parseFloat(userCommissionAmount);
                } else {
                    this.invoice[0].user_commission_amount = 0;
                }
            },
            alertDisplay(lineIndex) {
                this.$swal({
                    title: 'Are you sure?',
                    text: 'You can\'t revert your action',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes delete it!',
                    cancelButtonText: 'No, keep it!',
                    showCloseButton: true
                }).then((result) => {
                    if(result.value) {
                        if (this.lines[lineIndex].id != null && this.lines[lineIndex].id != "") {
                            this.$store.dispatch("invoices/destroyLine", {
                                invoice: this.invoice[0].id,
                                line: this.lines[lineIndex].id
                            }).then(() => {
                                this.$swal('Deleted', 'You successfully deleted this line', 'success')
                            }).catch(() => {
                                this.$swal({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!',
                                });
                            });
                        } else {
                            this.$store.commit('invoices/REMOVE_LINE', lineIndex);
                            this.$swal('Deleted', 'You successfully deleted this line', 'success')
                        }
                        this.setInvoicePrices();

                    } else {
                        this.$swal('Cancelled', 'Your line is still intact', 'info')
                    }
                })
            },
        }
    }
</script>

<style lang="scss" scoped>

</style>
