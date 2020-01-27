<template>
    <div>
        <ul class="nav nav-tabs nav-justified">
            <li class="nav-item">
                <a class="nav-link" @click.prevent="selectTab('header')" :class="{ active: isActive('header') }" href="#header">En-tête</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" @click.prevent="selectTab('body')" :class="{ active: isActive('body') }" href="#body">Corps</a>
            </li>
        </ul>
        <div class="tab-content py-3">
            <div class="tab-pane fade" v-if="currentTab === 'header'" :class="{ 'active show': isActive('header') }" id="home">header content</div>
            <div class="tab-pane fade" v-if="currentTab === 'body'" :class="{ 'active show': isActive('body') }" id="profile">body content</div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'tabs',
        data() {
            return {
                currentTab: 'header'
            }
        },
        methods: {
            selectTab(selectedTab) {
                this.currentTab = selectedTab;
            },
            isActive(menuItem) {
                return this.currentTab === menuItem
            },
        }
    }
</script>

<style lang="scss" scoped>

</style>
