<template>
    <show :pageTitle="'Facture #' + this.invoiceNo"
        v-on:save="save"
    />
</template>

<script>
    import show from './template';
    import { mapMultiRowFields } from 'vuex-map-fields';

    export default {
        components: {
            show
        },
        data() {
            return {
                invoiceNo: ""
            }
        },
        created() {
            this.$store.dispatch("invoices/edit", {
                id: this.$route.params.id,
            }).then(() => {
                this.invoiceNo = this.invoice[0].invoice_no;
            }).catch(error => {
                this.$swal({
                    position: 'top-end',
                    icon: 'error',
                    text: 'Oops...',
                    title: 'Un problème est survenu pour charger la facture',
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
        computed: {
            ...mapMultiRowFields('invoices', ['invoice']),
        },
        methods: {
            save() {
                console.log("update invoice");
                this.$store.dispatch("invoices/update").then(() => {

                }).catch(error => {
                    this.$swal({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Un problème est survenu pour enregistrer la facture',
                        showClass: {
                            popup: 'animated fadeInUp faster'
                        },
                        hideClass: {
                            popup: 'animated fadeOutRight faster'
                        },
                        timer: 5000,
                        timerProgressBar: true,
                    });
                });
            }
        }
    }
</script>
