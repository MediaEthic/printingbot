<template>
    <container :isLoading="isLoading">
        <div slot="content">
            <hero :illustration="`create.svg`">
                <h1 slot="title">Nouvelle facture</h1>
                <div slot="action">
                    <cta :label="`Annuler`"
                         :path="`invoices.index`"></cta>
                </div>
            </hero>

            <box>
                <div slot="content">
                    <div class="flex justify-start items-center">
                        <h2 class="font-serif text-3xl tracking-tighter mr-12">Facture (brouillon)</h2>
                        <tag :label="`Saisi`"
                             :color="`yellow`" />
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
                            <tabBody class="tab-pane fade" v-if="currentTab === 'body'" :class="{ 'active show': isActive('body') }" id="body" />
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
                    <fieldset class="fieldset" v-if="isActive('body')">
                        <legend class="legend">Actions</legend>

                        <btn :label="`Commentaire`"
                             :icon="`icon-message-circle`"
                             v-on:click="addLine('comment')">
                        </btn>

                        <btn :label="`Produit`"
                             :icon="`icon-file-plus`"
                             v-on:click="addLine('product')">
                        </btn>
                    </fieldset>
                </transition>

                <fieldset class="fieldset">
                    <legend class="legend">Modalités</legend>

                    <DatePicker v-model="form.header.invoice_date"
                                lang="en"
                                type="date"
                                format="YYYY-MM-dd"
                                placeholder="Date de facture"
                                input-class="field" />

                    <formInput :type="`select`"
                               :id="`payment_id`"
                               :label="`Mode de règlement`"
                               :items="[{id:'toto', name:'toto'}, {id:'tata', name:'tata'}, {id:'titi', name:'titi'}]"
                               :required="false"
                               v-model="form.header.payment_id" />

                    <formInput :type="`select`"
                               :id="`settlement_id`"
                               :label="`Conditions de règlement`"
                               :items="[{id:'toto', name:'toto'}, {id:'tata', name:'tata'}, {id:'titi', name:'titi'}]"
                               :required="false"
                               v-model="form.header.settlement_id" />

                    <formInput :type="`date`"
                               :id="`due_date`"
                               :label="`Date d'échéance`"
                               :disabled="true"
                               :required="false"
                               v-model="form.header.due_date" />
                </fieldset>
            </section>
        </div>
    </container>
</template>

<script>
    import { mapGetters } from 'vuex';

    import container from '../../layout/container';
    import hero from '../../layout/hero';
    import cta from '../../elements/cta';
    import box from '../../elements/box';
    import tag from '../../elements/tag';
    import btn from '../../elements/button';
    import tabHeader from "./tabs/header";
    import tabBody from "./tabs/body";
    import DatePicker from 'vue2-datepicker';
    import formInput from "../../form/input";

    export default {
        components: {
            container,
            hero,
            cta,
            box,
            tag,
            btn,
            tabHeader,
            tabBody,
            DatePicker,
            formInput,
        },
        data() {
            return {
                isLoading: true,
                currentTab: 'header',
                line: {
                    establishment_id: "",
                    invoice_line_no: "",
                    invoice_line_type: "",
                    order_id: "",
                    order_line: "",
                    delivery_id: "",
                    delivery_line: "",
                    product_id: "",
                    name: "",
                    description: "",
                    vat_id: "",
                    quantity: "",
                    unit_price: "",
                    discount_rate: "",
                    subtotal: "",
                    vat_amount: "",
                    total_amount: "",
                }
            }
        },
        mounted() {
            this.isLoading = false;
        },
        computed: {
            ...mapGetters({
                form: 'invoices/formInvoice',
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
            selectTab(selectedTab) {
                this.currentTab = selectedTab;
            },
            isActive(menuItem) {
                return this.currentTab === menuItem
            },
            addLine(type) {
                let newLine = this.line;
                if (type === "comment") {
                    newLine.invoice_line_type = "comment";
                } else {
                    newLine.invoice_line_type = "product";
                }
                this.form.body.lines.push(newLine);
            },
        }
    }
</script>
