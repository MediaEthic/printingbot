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

                    <ul class="nav nav-tabs nav-justified">
                        <li class="nav-item">
                            <a class="nav-link" @click.prevent="setActive('header')" :class="{ active: isActive('header') }" href="#header">En-tête</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" @click.prevent="setActive('body')" :class="{ active: isActive('body') }" href="#body">Corps</a>
                        </li>
                    </ul>
                    <div class="tab-content py-3">
                        <div class="tab-pane fade" :class="{ 'active show': isActive('header') }" id="home">header content</div>
                        <div class="tab-pane fade" :class="{ 'active show': isActive('body') }" id="profile">body content</div>
                    </div>
                </div>
            </box>
        </div>
    </container>
</template>

<script>
    import container from '../../layout/container';
    import hero from '../../layout/hero';
    import cta from '../../elements/cta';
    import box from '../../elements/box';
    import tag from "../../elements/tag";

    export default {
        components: {
            container,
            hero,
            cta,
            box,
            tag,
        },
        data() {
            return {
                isLoading: true,
                activeItem: 'header',
                currentTab: 'header'
            }
        },
        mounted() {
            this.isLoading = false;
        },
        methods: {
            isActive (menuItem) {
                return this.activeItem === menuItem
            },
            setActive (menuItem) {
                this.activeItem = menuItem
            }
        }
    }
</script>
