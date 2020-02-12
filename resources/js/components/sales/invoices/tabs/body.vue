<template>
    <div>
        <fieldset class="fieldset">
            <formInput :type="`text`"
                       :id="`name`"
                       :label="`Référence`"
                       :required="false"
                       :value="invoice[0].name" />

            <div class="container-table">
                <table class="wrap-table">
                    <thead class="table-header">
                    <tr class="table-row">
                        <th scope="col" class="table-cell">Description</th>
                        <th scope="col" class="table-cell">TVA</th>
                        <th scope="col" class="table-cell">Quantité</th>
                        <th scope="col" class="table-cell">Remise</th>
                        <th scope="col" class="table-cell">Prix unitaire</th>
                        <th scope="col" class="table-cell">Total HT</th>
                        <th scope="col" class="table-cell"> </th>
                    </tr>
                    </thead>
                    <tbody class="table-body">
                    <tr v-for="(line, index) in lines"
                        :key="index"
                        class="table-row fields-are-small"
                    >
                        <td class="table-cell" data-title="Description" :colspan="line.type === 'comment' ? 6 : 0">
                            <formInput v-if="line.type === 'comment'"
                                       :type="`textarea`"
                                       :id="`description` + index"
                                       v-model="line.description"
                                       label="Description"
                                       :required="true" />

                            <formInput v-else-if="line.description !== ''"
                                       :type="`text`"
                                       :id="`description` + index"
                                       v-model="line.description"
                                       label="Description"
                                       :required="true" />

                            <autocomplete v-else
                                          :id="`description` + index"
                                          label="Description"
                                          :required="true"
                                          :items="products"
                                          :isAsync="true"
                                          :focus="true"
                                          v-on:search="searchProducts"
                                          v-on:input="(...args)=>selectedProduct(index,...args)"
                            />
                        </td>
                        <td class="table-cell" data-title="TVA" v-if="line.type != 'comment'">
                            <formInput :type="`select`"
                                       :id="`vat_id` + index"
                                       v-model="line.vat_id"
                                       label="TVA"
                                       :choose="false"
                                       :required="true"
                                       :items="vats" />
                        </td>
                        <td class="table-cell" data-title="Quantité" v-if="line.type != 'comment'">
                            <formInput :type="`number`"
                                       :id="`quantity` + index"
                                       v-model="line.quantity"
                                       label="Quantité"
                                       :required="true"
                                       @input="setUnitPrice(index)" />
                        </td>
                        <td class="table-cell" data-title="Remise" v-if="line.type != 'comment'">
                            <formInput :type="`number`"
                                       :id="`discount_rate` + index"
                                       v-model="line.discount_rate"
                                       label="Remise"
                                       :required="false"
                                       @input="setUnitPrice(index)" />
                        </td>
                        <td class="table-cell" data-title="PU" v-if="line.type != 'comment'">
                            <formInput :type="`number`"
                                       :id="`unit_price` + index"
                                       v-model="line.unit_price"
                                       label="Prix unitaire"
                                       :required="false"
                                       @input="setLineTotal(index)" />
                        </td>
                        <td class="table-cell" data-title="Total HT" v-if="line.type != 'comment'">
                            <formInput :type="`number`"
                                       :id="`total_amount` + index"
                                       v-model="line.total_pretax"
                                       label="Total HT"
                                       :required="false"
                                       :readonly="true" />
                        </td>
                        <td class="table-cell relative" data-title="">
                            <btn :type="'delete'"
                                 v-on:click="alertDisplay(index)"
                            />
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </fieldset>

        <modal name="search-products" @opened="opened" :adaptive="true" :width="1180" :height="640">
            <div>
                <button type="button"
                        class="modal-close"
                        aria-label="Fermer la fenêtre modale"
                        @click="hide">
                </button>
<!--                <Loader v-if="searchSubstrates.isLoading" />-->
                <h3 class="page-main-title modal-header">Rechercher un article</h3>

                <div class="modal-body">
                    <form action="#" method="post" class="form-filters">
                        <autocomplete :id="`description`"
                                      label="Description"
                                      :required="true"
                                      :items="products"
                                      :isAsync="true"
                                      :focus="true"
                                      v-on:search="searchProducts"
                                      v-on:input="(...args)=>selectedProduct(index,...args)"
                        />

<!--                        <button type="submit"-->
<!--                                class="button button-small button-primary"-->
<!--                                style="margin-left: auto;"-->
<!--                                @click.prevent="getFilteredSubstrates"-->
<!--                                @keydown.tab.exact.prevent="">-->
<!--                            Rechercher-->
<!--                            <i class="fas fa-search"></i>-->
<!--                        </button>-->
                    </form>

<!--                    <div class="container-table" v-if="searchSubstrates.substrates.length || Object.keys(searchSubstrates.substrates).length">-->
<!--                        <table class="wrap-table">-->
<!--                            <thead class="table-header">-->
<!--                            <tr class="table-row">-->
<!--                                <th scope="col" class="table-cell">Base Ethic</th>-->
<!--                                <th scope="col" class="table-cell">Famille</th>-->
<!--                                <th scope="col" class="table-cell">Type</th>-->
<!--                                <th scope="col" class="table-cell">Désignation</th>-->
<!--                                <th scope="col" class="table-cell">Couleur</th>-->
<!--                                <th scope="col" class="table-cell">Grammage</th>-->
<!--                                <th scope="col" class="table-cell">Laize</th>-->
<!--                                <th scope="col" class="table-cell">Prix</th>-->
<!--                            </tr>-->
<!--                            </thead>-->
<!--                            <tbody class="table-body">-->
<!--                            <tr class="table-row" v-for="(substrate, index) in searchSubstrates.substrates" :key="index" @click="selectedSubstrate(substrate)">-->
<!--                                <td class="table-cell" data-title="Base Ethic">{{ substrate.ethic ? "Oui" : "Non" }}</td>-->
<!--                                <td class="table-cell" data-title="Famille">{{ substrate.family }}</td>-->
<!--                                <td class="table-cell" data-title="Type">{{ substrate.type }}</td>-->
<!--                                <td class="table-cell" data-title="Désignation">{{ substrate.name }}</td>-->
<!--                                <td class="table-cell" data-title="Couleur">{{ substrate.color }}</td>-->
<!--                                <td class="table-cell" data-title="Grammage">{{ substrate.weight }}</td>-->
<!--                                <td class="table-cell" data-title="Laize">{{ substrate.width }}</td>-->
<!--                                <td class="table-cell" data-title="Prix">{{ substrate.price }}</td>-->
<!--                            </tr>-->
<!--                            </tbody>-->
<!--                        </table>-->
<!--                        <Pagination :pagination="searchSubstrates.pagination" v-on:fetchResults="getFilteredSubstrates"></Pagination>-->
<!--                    </div>-->
                    <div class="wrap-empty-result">
                        <p class="text-no-data">Aucun résultat trouvé</p>
                        <img class="image-no-data"
                             src="/assets/img/waiting_for_search.svg"
                             alt="En attente d'une recherche"/>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import { mapMultiRowFields } from 'vuex-map-fields';

    import formInput from "../../../form/input";
    import btn from '../../../elements/button';
    import DatePicker from 'vue2-datepicker';
    import autocomplete from "../../../form/autocomplete";

    export default {
        components: {
            autocomplete,
            formInput,
            btn,
            DatePicker,
        },
        data() {
            return {

            }
        },
        created() {

        },
        computed: {
            ...mapMultiRowFields('invoices', ['invoice', 'lines']),
            ...mapGetters({
                products: 'products/filteredProducts',
                vats: 'vats/allVats',
            }),
        },
        methods: {
            show() {
                this.$modal.show('search-products');
            },
            hide() {
                this.$modal.hide('search-products');
            },
            opened() {
                // if (this.database.printing.substrates.search.criteria.types.length < 1) {
                //     this.getSubstratesSearchCriteria();
                // }
            },
            searchProducts(query) {
                this.$store.dispatch("products/searchProducts", {
                    query: query
                }).then(() => {
                    console.log(this.products);
                }).catch(error => {
                    console.log(error);
                    console.log(error.response);
                    this.$swal({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Oups, un problème est survenu pour charger les articles',
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
            getFilteredSubstrates(page) {
                // page = page || 1;
                // this.$store.dispatch("getFilteredSubstrates", {
                //     filters: this.searchSubstrates.criteria,
                //     page: parseInt(page)
                // }).then(response => {
                //     this.searchSubstrates.substrates = response.data;
                //     console.log(this.searchSubstrates.substrates);
                //     // this.searchSubstrates.isLoading = false;
                //     this.makePagination(response);
                // }).catch(error => {
                //     this.searchSubstrates.substrates = [];
                //     this.$toast.error({
                //         title: "Erreur",
                //         message: "Oups, un problème est survenu pour charger les supports d'impression"
                //     });
                //     this.searchSubstrates.isLoading = false;
                // });
            },
            selectedProduct(index, value) {
                this.lines[index].description = value.name;
                this.lines[index].product_id = value.id;
                this.lines[index].product = value;
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
                                } else {
                                    console.log("no unit price found <= quantity")
                                }
                            }
                        } else {
                            console.log("no unit price found >= quantity")
                        }
                    }
                    this.lines[index].unit_price = unitPrice;
                    this.setLineTotal(index);
                }
            },
            setLineTotal(index) {
                console.log(index);
                let unitPrice = parseFloat(this.lines[index].unit_price);
                let quantity = parseFloat(this.lines[index].quantity);
                let discount = parseFloat(this.lines[index].discount_rate);

                let subtotal = parseFloat((quantity * unitPrice).toFixed(2));
                // this.$store.commit('invoices/SET_LINE_SUBTOTAL', subtotal);
                this.lines[index].subtotal = subtotal;

                let discountAmount = parseFloat((subtotal * (discount / 100)).toFixed(2));
                this.lines[index].discount_amount = discountAmount;

                let total_pretax = parseFloat((subtotal - discountAmount).toFixed(2));
                this.lines[index].total_pretax = total_pretax;

                let vat = this.vats.filter(vat => vat.id === parseInt(this.lines[index].vat_id))[0];
                let amountVat = parseFloat((total_pretax * (vat.rate / 100)).toFixed(2));
                this.lines[index].vat = amountVat;

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
                        invoiceVat += parseFloat(value.vat);
                        invoiceTotal += parseFloat(value.total);
                    }
                }

                this.invoice[0].subtotal = invoiceSubtotal;
                this.invoice[0].discount_amount = invoiceDiscountAmount;
                this.invoice[0].total_pretax = invoiceTotalPretax;
                this.invoice[0].vat = invoiceVat;
                this.invoice[0].total = invoiceTotal;

                this.invoice[0].user_commission_base = invoiceTotalPretax;
                if (parseFloat(this.invoice[0].user_commission_rate > 0)) {
                    this.invoice[0].user_commission_amount = (parseFloat(this.invoice[0].total_pretax) * (parseFloat(this.invoice[0].user_commission_rate) / 100)).toFixed(2);
                }

                this.$emit('animation');
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
                            console.log(this.lines);
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
