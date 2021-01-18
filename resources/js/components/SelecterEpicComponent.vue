<!-- todo edit app.js: Vue.component('component-name', require('./components/ComponentName.vue').default);-->
<template>
    <div class="row card-box">
        <div class="col-lg-4">
            <div class="table-responsive table-striped">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title">{{ ('epics') }}</h4>
                        <input v-model="filter" placeholder="search">
                    </div>

                    <div class="card-body">
                        <table class="quotation table mb-0">
                            <thead>
                            <tr>
                                <th @click="sortColum('title')">
                                    {{('title')}}
                                    <span>
                                        <i v-if="order === 'asc' " class="fas fa-arrow-up"></i>
                                        <i v-else class="fas fa-arrow-down"></i>
                                    </span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="epic in filteredEpics">
                                <td @click="select(epic)">{{ epic.title }}</td>
                            </tr>
                            <tr v-if="filteredEpics.length === 0">
                                <td>
                                    no results found
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <selecter-task-component v-if="selectedEpic" :selectedepic="selectedEpic"></selecter-task-component>
        </div>
    </div>

</template>

<script>
    import SelecterTaskComponent from "./SelecterTaskComponent";
    import SortedTablePlugin from "vue-sorted-table";
    // import { SortedTable, SortLink } from "vue-sorted-table";

    export default {
        name: "SelecterEpic",
        components: {
            SelecterTaskComponent: SelecterTaskComponent,
            SortedTablePlugin,
        },
        mounted() {
            console.log('selectEpic component mounted.')
            this.epic = false;
            this.getAllEpics();
        },
        props: {
            data: Array,
        },
        data() {
            return {
                filter: "",
                selected: Array,
                epics: Array,
                epic: Array,
                tasks: Array,
                epicForm: {
                    title: '',
                    description: '',
                },
                titError: '',
                descError: '',
                selectedEpic: undefined,
                order: 'asc',
                orderColum: 'id',
            }
        },
        computed: {
            filteredEpics() {
                const search = this.filter.toLowerCase().trim();
                if (!search) return this.epics;
                return this.epics.filter(e => e.title.toLowerCase().indexOf(search) > -1);
            },

        },
        watch: {
            sortColum(){
            }
        },
        methods: {
            getAllEpics() {
                let that = this;
                axios
                    .get(route('epics.index')).then((res) => {
                    this.epics = _.orderBy(res.data, that.orderColum, that.order)
                }).catch((err) => {
                    console.log(err)
                });
            },
            select(epic) {
                console.log('selected epic: ', epic);
                // axios call
                this.selectedEpic = epic;
                // callback
                // this.$parent.$rerfs.tasks.tasks = result;
            },
            sortColum(colum){
                let that = this;
                if (that.order === "desc"){
                    that.order = "asc";
                    that.orderColum = colum;
                    that.getAllEpics();
                }
                else if (that.order === "asc"){
                    that.order = "desc";
                    that.orderColum = colum;
                    that.getAllEpics();
                }
            }
        }
    }
</script>
