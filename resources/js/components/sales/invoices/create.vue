<template>
    <show
        pageTitle="Nouvelle facture"
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
                //
            }
        },
        created() {
            this.$store.dispatch("invoices/create").then(() => {
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
            save(invoice) {
                this.$store.dispatch("invoices/store").then(() => {
                    this.$router.push({ name: 'invoices.edit', params: { id: invoice.id } });
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
