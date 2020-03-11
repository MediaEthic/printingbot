<template>
    <nav v-if="pagination.last_page > 1"
         class="pagination-container">
        <ul class="wrap-pagination">
            <li class="pagination-item" v-if="!isInFirstPage">
                <button
                    type="button"
                    @click="onClickFirstPage"
                    :disabled="isInFirstPage"
                    class="pagination-controls"
                >
                    <i class="icon-chevrons-left"></i>
                </button>
            </li>

            <li class="pagination-item" v-if="!isInFirstPage">
                <button
                    type="button"
                    @click="onClickPreviousPage"
                    :disabled="isInFirstPage"
                    class="pagination-controls"
                >
                    <i class="icon-chevron-left"></i>
                </button>
            </li>

            <li v-for="page in pages"
                class="pagination-item"
            >
                <button
                    type="button"
                    @click="onClickPage(page.name)"
                    :disabled="page.isDisabled"
                    :class="{ active: isPageActive(page.name) }"
                    class="pagination-controls"
                >
                    {{ page.name }}
                </button>
            </li>

            <li class="pagination-item" v-if="!isInLastPage">
                <button
                    type="button"
                    @click="onClickNextPage"
                    :disabled="isInLastPage"
                    class="pagination-controls"
                >
                    <i class="icon-chevron-right"></i>
                </button>
            </li>

            <li class="pagination-item" v-if="!isInLastPage">
                <button
                    type="button"
                    @click="onClickLastPage"
                    :disabled="isInLastPage"
                    class="pagination-controls"
                >
                    <i class="icon-chevrons-right"></i>
                </button>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: "pagination",
        props: {
            maxVisibleButtons: {
                type: Number,
                required: false,
                default: 3
            },
            pagination: {
                type: Object,
                required: true,
                default: () => {}
            },
        },
        data() {
            return {
                pageRequested: 1
            }
        },
        computed: {
            startPage() {
                // When on the first page
                if (this.pagination.current_page === 1) {
                    return 1;
                } else if (this.pagination.current_page === this.pagination.last_page) { // When on the last page
                    return this.pagination.last_page - this.maxVisibleButtons + 1;
                } else { // When in between
                    return this.pagination.current_page - 1;
                }
            },
            pages() {
                const range = [];
                for (let i = this.startPage;
                     i <= Math.min(this.startPage + this.maxVisibleButtons - 1, this.pagination.last_page);
                     i+= 1 ) {
                    range.push({
                        name: i,
                        isDisabled: i === this.pagination.current_page
                    });
                }

                return range;
            },
            isInFirstPage() {
                return this.pagination.current_page === 1;
            },
            isInLastPage() {
                return this.pagination.current_page === this.pagination.last_page;
            },
        },
        methods: {
            onClickFirstPage() {
                this.$emit('pagechanged', 1);
            },
            onClickPreviousPage() {
                this.$emit('pagechanged', this.pagination.current_page - 1);
            },
            onClickPage(page) {
                this.$emit('pagechanged', page);
            },
            onClickNextPage() {
                this.$emit('pagechanged', this.pagination.current_page + 1);
            },
            onClickLastPage() {
                this.$emit('pagechanged', this.pagination.last_page);
            },
            isPageActive(page) {
                return this.pagination.current_page === page;
            },
        }
    }
</script>

<style lang="scss" scoped>
    .pagination-container {
        width: 100%;

        .wrap-pagination {
            display: flex;
            justify-content: center;
            margin-top: 1rem;

            .pagination-item {
                background-color: theme('colors.purple5');

                &:first-child {
                    border-top-left-radius: 2rem;
                    border-bottom-left-radius: 2rem;
                }

                &:last-child {
                    border-top-right-radius: 2rem;
                    border-bottom-right-radius: 2rem;
                }

                .pagination-controls {
                    cursor: pointer;
                    padding: 1rem;
                    width: 3.5rem;
                    border-radius: 50%;
                    color: theme('colors.purple1');
                    transition: all .4s;

                    &.active {
                        background-color: theme('colors.purple1');
                        color: theme('colors.white');
                    }

                    &:hover {
                        background-color: theme('colors.purple3');
                        color: theme('colors.purple5');
                        border-radius: 50%;
                    }
                }
            }
        }
    }
</style>
