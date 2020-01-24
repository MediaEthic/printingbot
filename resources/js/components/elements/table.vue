<template>
    <div class="container-table">
        <table class="wrap-table">
            <thead class="table-header">
                <tr class="table-row">
                    <th v-for="header in headers"
                        scope="col"
                        class="table-cell">
                        {{ header }}
                    </th>
                </tr>
            </thead>
            <tbody class="table-body">
                <tr v-for="(row, index) in rows"
                    :key="index"
                    @click="showRow(row.id)"
                    class="table-row"
                >
                    <td v-for="(cell, key) in row"
                        class="table-cell"
                        :data-title="key">
                        <div v-if="selection && key === 'id'" class="checkbox">
                            <input type="checkbox" :id="'check' + index" :name="'check' + index" />
                            <label :for="'check' + index">
                                <span><!-- This span is needed to create the "checkbox" element --></span>
                            </label>
                        </div>

                        <div v-else>
                            <tag v-if="tag === key"
                                 :label="cell"></tag>
                            <span v-else>{{ cell }}</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import tag from '../elements/tag';

    export default {
        components: {
            tag,
        },
        props: {
            headers: {
                type: Array,
                required: false,
                default: () => []
            },
            values: {
                type: Object,
                required: false,
                default: () => {}
            },
            tag: {
                type: String,
                required: false,
                default: ""
            },
            selection: {
                type: Boolean,
                required: false,
                default: false
            },
            path: {
                type: String,
                required: false,
                default: "dashboard.index"
            },
        },
        data() {
            return {
                items: [],
                rows: [],
            }
        },
        created() {
            console.log(this.values)

        },
        watch: {
            values(value, oldValue) {
                console.log(value);
                this.rows = value.data;
            },
        },
        methods: {
            convertArrayToObject(array, key) {
                const initialValue = {};
                return array.reduce((obj, item) => {
                    return {
                        ...obj,
                        [item[key]]: item,
                    };
                }, initialValue);
            },
            showRow(id) {
                this.$router.push({ name: this.path, params: { id: id } });
            }
        }
    }
</script>

<style lang="scss">
    label {
        cursor: pointer;
        position: relative;

        span {
            display: inline-block;
            position: relative;
            background-color: transparent;
            width: 2.5rem;
            height: 2.5rem;
            transform-origin: center;
            border: .2rem solid theme('colors.grey');
            border-radius: 50%;
            vertical-align: -6px;
            margin-right: 10px;
            transition: background-color 150ms 200ms, background-color 150ms 200ms, transform 350ms cubic-bezier(.78,-1.22,.17,1.89);

            &:before {
                content: "";
                width: 0;
                height: .2rem;
                border-radius: .2rem;
                background: theme('colors.grey');
                position: absolute;
                transform: rotate(45deg);
                top: 1rem;
                left: .7rem;
                transition: width 50ms ease 50ms;
                transform-origin: 0 0;
            }

            &:after {
                content: "";
                width: 0;
                height: .2rem;
                border-radius: .2rem;
                background: theme('colors.grey');
                position: absolute;
                transform: rotate(305deg);
                top: 1.4rem;
                left: .8rem;
                transition: width 50ms ease;
                transform-origin: 0 0;
            }
        }
        &:hover {
            span {
                &:before {
                    width: .5rem;
                    transition: width 100ms ease;
                }

                &:after {
                    width: 1rem;
                    transition: width 150ms ease 100ms;
                }
            }
        }
    }

    input[type="checkbox"] {
        display: none;

        &:checked {
            + label {
                span {
                    border-color: theme('colors.yellow1');
                    background-color: theme('colors.yellow1');
                    transform: scale(1.25);

                    &:after {
                        width: 1rem;
                        background: theme('colors.white');
                        transition: width 150ms ease 100ms;
                    }

                    &:before {
                        width: .5rem;
                        background: theme('colors.white');
                        transition: width 150ms ease 100ms;
                    }
                }

                &:hover {
                    span {
                        background-color: theme('colors.yellow5');
                        transform: scale(1.25); // enlarge the box

                        &:after {
                            width: 1rem;
                            background: theme('colors.yellow1');
                            transition: width 150ms ease 100ms; // enlarge the tick
                        }

                        &:before {
                            width: 5px;
                            background: theme('colors.yellow1');
                            transition: width 150ms ease 100ms; // enlarge the tick
                        }
                    }
                }
            }
        }
    }


    // Table responsive
    .container-table {
        width: 100%;
        overflow-x: scroll;

        .wrap-table {
            border-spacing: 0;
            border-collapse: collapse;
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            width: 100%;
            margin: 2rem auto 0 auto;
            /*box-shadow: 0 0 1rem 0 rgba(theme('colors.black'), .1);*/

            .table-cell {
                text-align: left;
                padding: 1rem 0 1rem 2rem;

                &:last-child {
                    padding-right: 2rem;
                }

                &.right {
                    text-align: right;
                }
            }

            .table-header {
                vertical-align: top;
                /*background-color: theme('colors.black');*/

                .table-row {
                    background-color: theme('colors.black');

                    .table-cell {
                        letter-spacing: .1em;
                        font-weight: 500;
                        text-transform: uppercase;
                        color: theme('colors.purple5');
                    }
                }
            }

            .table-body {
                .table-row {
                    cursor: pointer;

                    &:not(:last-child) {
                        border-bottom: .1rem solid theme('colors.grey');
                    }

                    &:nth-child(even) {
                        /*background-color: rgba(theme('colors.grey'), .1);*/
                    }

                    &:active {
                        /*background-color: rgba(theme('colors.grey'), .3);*/
                    }

                    &:hover {
                        background-color: theme('colors.gray.100');
                    }

                    .table-cell {
                        font-size: 1.4rem;
                        line-height: 1.8rem;
                        text-align: left;
                        /*color: theme('colors.black');*/
                    }
                }
            }
        }
    }

    @media screen and (max-width: 768px) {
        .container-table {
            .wrap-table {
                display: block;

                > *,
                .table-row,
                .table-cell {
                    display: block;
                }

                .table-header {
                    display: none;
                }

                .table-body {
                    .table-row {
                        padding: 3rem 1.5rem 2rem 3rem;
                        width: 100%;

                        .table-cell {
                            display: block;
                            padding: 1.5rem 0;

                            &:before {
                                content: attr(data-title);
                                letter-spacing: .1em;
                                font-weight: 700;
                                text-transform: uppercase;
                                /*color: theme('colors.black');*/
                                margin-bottom: 1rem;
                                display: block;
                            }
                        }
                    }
                }
            }
        }
    }
</style>
