<template>
    <ValidationObserver tag="div" v-slot="{ invalid, passes }">
        <form enctype="multipart/form-data" @submit.prevent="passes(save)">
        <container :isLoading="isLoading">
            <div slot="content">
                <hero :illustration="`create.svg`">
                    <h1 slot="title">{{ pageTitle }}</h1>
                    <div slot="action">
                        <btn type="cta"
                             :label="`Annuler`"
                             v-on:click="cancelInvoiceChanges" />
                    </div>
                </hero>

                <box>
                    <div slot="content">
                        <div class="flex justify-start items-center">
                            <h2 class="font-serif text-3xl tracking-tighter mr-8">#{{ invoice[0].invoice_no }}</h2>
                            <tag :label="setInvoiceStatus()"
                                 :color="defineColorTag()" />
                            <nav class="menu">
                                <input id="menu-toggler" class="menu-toggler" type="checkbox">
                                <label for="menu-toggler"><i class="icon-settings"></i></label>
                                <ul class="menu-list">
                                    <li class="menu-item">
                                        <a class="menu-action icon-printer" target="_blank" :href="'/api/auth/sales/invoices/' + JSON.stringify([invoice[0].id]) + '/pdf'" title="Imprimer la facture"></a>
                                    </li>
                                    <li class="menu-item">
                                        <button type="button" @click.prevent="" class="menu-action icon-copy" title="Dupliquer la facture"></button>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <div class="wrap-tabs">
                            <ul class="nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link" @click.prevent="selectTab('header')" :class="{ active: isActive('header') }" href="#header">En-tête</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" @click.prevent="selectTab('body')" :class="{ active: isActive('body') }" href="#body">Corps</a>
                                </li>
                            </ul>

                            <div class="content-tabs">
                                <tabHeader class="tab-pane fade" v-if="currentTab === 'header'" :class="{ 'active show': isActive('header') }" id="home" />
                                <tabBody class="tab-pane fade"
                                         v-if="currentTab === 'body'"
                                         :class="{ 'active show': isActive('body') }"
                                         id="body"
                                />
                            </div>
                        </div>
                    </div>
                </box>
            </div>

            <div slot="sidebar">
                <section>
                    <transition name="slide-right"
                                mode="out-in"
                                @beforeLeave="beforeLeave"
                                @enter="enter"
                                @afterEnter="afterEnter">
                        <fieldset class="fieldset" v-if="isActive('body') && invoice[0].invoice_status === 'draft'">
                            <legend class="legend">Actions</legend>

                            <btn
                                v-if="isActive('body')"
                                type="button"
                                :label="`Commentaire`"
                                :icon="`icon-message-circle`"
                                v-on:click="addLine('comment')"
                            />

                            <btn
                                v-if="isActive('body')"
                                type="button"
                                :label="`Produit`"
                                :icon="`icon-file-plus`"
                                v-on:click="addLine('product')"
                            />
                        </fieldset>
                    </transition>

                    <fieldset class="fieldset">
                        <legend class="legend">Modalités</legend>

                        <field
                            :type="`select`"
                            id="invoice_status"
                            label="Statut"
                            :items="statuses"
                            :required="true"
                            v-model="invoice[0].status"
                            :disabledChoose="true"
                            :disabled="invoice[0].invoice_status === 'draft' ? false : true"
                        />

                        <DatePicker
                            v-model="invoice[0].invoice_date"
                            :class="{ 'has-val': invoice[0].invoice_date }"
                            data-title="Date de facture"
                            placeholder="Date de facture"
                            :disabled-date="notAfterToday"
                            lang="fr"
                            type="date"
                            value-type="YYYY-MM-DD"
                            format="DD/MM/YYYY"
                            input-class="field"
                            @change="changeInvoiceDueDate"
                            :disabled="invoice[0].invoice_status === 'draft' ? false : true"
                        />

                        <field
                            :type="`select`"
                            id="payment_id"
                            v-model="invoice[0].payment_id"
                            label="Mode de règlement"
                            :required="true"
                            :items="payments"
                            :disabled="invoice[0].invoice_status === 'draft' ? false : true"
                        />

                        <field
                            :type="`select`"
                            id="settlement_id"
                            v-model="invoice[0].settlement_id"
                            label="Conditions de règlement"
                            :required="true"
                            :items="settlements"
                            v-on:updateField="changeInvoiceDueDate"
                            :disabled="invoice[0].invoice_status === 'draft' ? false : true"
                        />

                        <DatePicker
                            v-model="invoice[0].due_date"
                            :class="{ 'has-val': invoice[0].due_date }"
                            data-title="Date d'échéance"
                            placeholder="Date d'échéance"
                            disabled
                            :editable="false"
                            :clearable="false"
                            lang="fr"
                            type="date"
                            value-type="YYYY-MM-DD"
                            format="DD/MM/YYYY"
                            input-class="field"
                        />
                    </fieldset>

                    <fieldset class="fieldset">
                        <legend class="legend">Totaux</legend>
                        <ul>
                            <li class="flex justify-between">
                                <span class="text-base font-semibold uppercase tracking-widest text-purple4 mr-4">
                                    Sous-total
                                </span>
                                <span class="text-white text-lg font-bold tracking-widest">{{ invoice[0].subtotal }}</span>
                            </li>
                            <li class="flex justify-between mt-8">
                                <span class="text-base font-semibold uppercase tracking-widest text-purple4 mr-4">
                                    Remise
                                </span>
                                <span class="text-white text-lg font-bold tracking-widest">{{ invoice[0].discount_amount }}</span>
                            </li>
                        </ul>

                        <hr class="line-break" />

                        <ul class="mb-12">
                            <li class="flex justify-between">
                                <span class="text-base font-semibold uppercase tracking-widest text-purple4 mr-4">
                                    Total HT
                                </span>
                                <span class="text-white text-lg font-bold tracking-widest">{{ invoice[0].total_pretax }}</span>
                            </li>
                            <li class="flex justify-between mt-8">
                                <span class="text-base font-semibold uppercase tracking-widest text-purple4 mr-4">
                                    Total TVA
                                </span>
                                <span class="text-white text-lg font-bold tracking-widest">{{ invoice[0].vat }}</span>
                            </li>
                            <li class="flex justify-between mt-8">
                                <span class="text-base font-semibold uppercase tracking-widest text-purple4 mr-4">
                                    Total TTC
                                </span>
                                <span class="text-white text-lg font-bold tracking-widest">{{ invoice[0].total }}</span>
                            </li>
                        </ul>

                        <btn type="submit"
                             :disabled="invalid || invoice[0].invoice_status !== 'draft'"
                             :label="`Sauvegarder`"
                             :responsive="false"
                             :primary="true" />
                    </fieldset>
                </section>
            </div>
        </container>
        </form>
    </ValidationObserver>
</template>

<script>
    import { mapMultiRowFields } from 'vuex-map-fields';
    import { mapGetters } from 'vuex';
    import moment from 'moment';

    import container from '../../layout/container';
    import hero from '../../layout/hero';
    import box from '../../elements/box';
    import tag from '../../elements/tag';
    import btn from '../../elements/button';
    import tabHeader from "./tabs/header";
    import tabBody from "./tabs/body";
    import DatePicker from 'vue2-datepicker';
    import field from "../../elements/field";

    const today = moment().format('YYYY-MM-DD');

    export default {
        props: {
            pageTitle: {
                type: String,
                required: true,
                default: "Nouvelle facture"
            },
        },
        components: {
            container,
            hero,
            box,
            tag,
            btn,
            tabHeader,
            tabBody,
            DatePicker,
            field,
        },
        data() {
            return {
                isLoading: false,
                statuses: [
                    { id: "draft", name: "Saisie" },
                    { id: "edited", name: "Editée" },
                    { id: "payed", name: "Payée" },
                ],
                currentTab: 'header',
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
        },
        computed: {
            ...mapMultiRowFields('invoices', ['invoice', 'lines']),
            ...mapGetters({
                payments: 'payments/allPayments',
                settlements: 'settlements/allSettlements',
                salespersons: 'users/salespersons',
                vats: 'vats/allVats',
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
            notAfterToday(date) {
                return date > today;
            },
            cancelInvoiceChanges() {
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, don\'t save!'
                }).then((result) => {
                    if (result.value) {
                        this.$router.push({ name: 'invoices.index' });
                    }
                })
            },
            setInvoiceStatus() {
                if (this.invoice[0].invoice_status === "draft") {
                    return 'saisie';
                } else if (this.invoice[0].invoice_status === "edited") {
                    return 'éditée';
                }  else if (this.invoice[0].invoice_status === "payed") {
                    return 'payée';
                } else {
                    return 'saisie';
                }
            },
            defineColorTag() {
                const status = this.invoice[0].invoice_status;
                if (status === "draft") {
                    return "yellow";
                } else if (status === "edited") {
                    return "red";
                } else {
                    return "purple";
                }
            },
            changeInvoiceDueDate() {
                let value = parseInt(this.invoice[0].settlement_id);
                if (value > 0) {
                    let settlement = this.settlements.find(settlement => settlement.id === value);
                    let dueDate = today;
                    dueDate = moment(this.invoice[0].invoice_date, "YYYY-MM-DD").add(settlement.payment_within, 'days');
                    if (settlement.payment_on === 99) {
                        dueDate = moment(dueDate, "YYYY-MM-DD").endOf('month');
                    } else if (settlement.payment_on > 0) {
                        let year = moment(dueDate, "YYYY-MM-DD").year();
                        let month = moment(dueDate, "YYYY-MM-DD").month();
                        let day = moment(dueDate, "YYYY-MM-DD").day();

                        if (day <= settlement.payment_on) {
                            dueDate = moment().year(year).month(month).date(settlement.payment_on);
                        } else {
                            let nextMonth = moment(dueDate, "YYYY-MM-DD").add(1, 'month');
                            dueDate = moment().year(year).month(nextMonth).date(settlement.payment_on);
                        }
                    }
                    this.$store.commit('invoices/SET_DUE_DATE', moment(dueDate, "YYYY-MM-DD").format("YYYY-MM-DD"));
                } else {
                    this.$store.commit('invoices/SET_DUE_DATE', today);
                }
            },
            selectTab(selectedTab) {
                this.currentTab = selectedTab;
            },
            isActive(menuItem) {
                return this.currentTab === menuItem
            },
            addLine(type) {
                let newLine = {
                    id: "",
                    establishment_id: "",
                    type: "product",
                    name: "",
                    description: "",
                    order_line_id: "",
                    delivery_line_id: "",
                    product_id: "",
                    vat_id: "",
                    quantity: 1,
                    unit_price: 0,
                    subtotal: 0,
                    discount_rate: 0,
                    discount_amount: 0,
                    total_pretax: 0,
                    vat: 0,
                    total: 0,
                    product: "",
                };
                let defaultVat = this.vats.filter(vat => vat.default)[0];
                if (type === "comment") {
                    newLine.type = "comment";
                }
                newLine.vat_id = defaultVat.id;
                this.$store.commit('invoices/ADD_LINE', newLine);
            },
            save() {
                this.$emit('save');
            }
        }
    }
</script>



<style lang="scss" scoped>
    .menu {
        position: relative;
        margin-left: auto;
        width: 3rem;
        height: 3rem;

        .menu-toggler {
            position: absolute;
            display: block;
            top: 0;
            bottom: 0;
            right: 0;
            left: 0;
            margin: auto;
            width: 3rem;
            height: 3rem;
            z-index: 2;
            opacity: 0;
            cursor: pointer;

            &:checked {
                & + label > * {
                    transform: rotate(45deg) ;
                }

                & ~ .menu-list .menu-item {
                    opacity: 1;

                    &:nth-child(1) {
                        transform: rotate(0deg) translateY(3.5rem);
                    }
                    &:nth-child(2) {
                        transform: rotate(60deg) translateX(6rem) translateY(3.5rem);
                    }
                    &:nth-child(3) {
                        transform: rotate(120deg) translateX(-110px);
                    }
                    &:nth-child(4) {
                        transform: rotate(180deg) translateX(-110px);
                    }
                    &:nth-child(5) {
                        transform: rotate(240deg) translateX(-110px);
                    }
                    &:nth-child(6) {
                        transform: rotate(300deg) translateX(-110px);
                    }
                    .menu-action {
                        pointer-events:auto;
                    }
                }
            }

            & + label {
                text-align: center;
                font-size: 2rem;
                color: theme('colors.black');
                display: block;
                padding: .5rem;
                z-index: 1;
                border-radius: 50%;
                background-color: theme('colors.yellow1');
                transition: transform 0.5s top 0.5s;
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                margin: auto;

                & ~ .menu-list {
                    .menu-item {
                        position: absolute;
                        display: block;
                        top: 0;
                        bottom: 0;
                        left: 0;
                        right: 0;
                        margin: auto;
                        width: 3rem;
                        height: 3rem;
                        opacity: 0;
                        transition: 0.5s;

                        &:nth-child(1) .menu-action {
                            transform: rotate(0deg);
                        }
                        &:nth-child(2) .menu-action {
                            transform: rotate(-60deg);
                        }
                        &:nth-child(3) .menu-action {
                            transform: rotate(-120deg);
                        }
                        &m:nth-child(4) .menu-action {
                            transform: rotate(-180deg);
                        }
                        &:nth-child(5) .menu-action {
                            transform: rotate(-240deg);
                        }
                        &:nth-child(6) .menu-action {
                            transform: rotate(-300deg);
                        }

                        .menu-action {
                            display: block;
                            width: inherit;
                            height: inherit;
                            line-height: 3rem;
                            color: theme('colors.black');
                            background: theme('colors.yellow1');
                            border-radius: 50%;
                            text-align: center;
                            text-decoration: none;
                            font-size: 2rem;
                            pointer-events: none;
                            transition: 0.2s;

                            &:hover {
                                color: theme('colors.purple1');
                                background: theme('colors.purple5');
                                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                                font-size: 2.5rem;
                            }
                        }
                    }
                }
            }

            &:hover,
            &:checked {
                & + label {
                    color: theme('colors.purple1');
                    background-color: theme('colors.purple5');
                    transform: rotate(360deg);
                }
            }
        }
    }
</style>
