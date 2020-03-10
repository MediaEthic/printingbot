<template>
    <div>
        <loader v-if="isLoading"></loader>
        <show :pageTitle="'Facture'"
            v-on:save="save"
        />
    </div>
</template>

<script>
    import loader from '../../elements/loader';
    import show from './template';
    import { mapMultiRowFields } from 'vuex-map-fields';

    export default {
        components: {
            loader,
            show
        },
        data() {
            return {
                isLoading: false,
            }
        },
        created() {
            this.isLoading = true;
            this.$store.dispatch("invoices/edit", {
                id: this.$route.params.id,
            }).then(() => {
                // don't remember what it is for
                // this.$store.commit('invoices/SET_INVOICE_CURRENT_STATUS', this.invoice[0].invoice_status);
                this.isLoading = false;
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
                this.isLoading = true;
                this.invoice[0].invoice_status = this.invoice[0].status;
                this.$store.dispatch("invoices/update").then(() => {
                    this.isLoading = false;
                }).catch(error => {
                    this.isLoading = false;
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
