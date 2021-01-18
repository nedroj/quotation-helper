<!-- todo edit app.js: Vue.component('component-name', require('./components/ComponentName.vue').default);-->
<template>
    <div>
        <div class="table-responsive table-striped">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">{{ ('Tasks') }}</h4>
                    <p>Selected epic: {{ selectedepic.title }}</p>
                    <p>description: {{selectedepic.description}}</p>
                    <input v-model="filter" placeholder="search">
                </div>

                <div class="card-body">
                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th @click="sortColum('title')">
                                {{ ('title') }}
                                <span>
                                    <i v-if="orderTitle === 'asc' " class="fas fa-arrow-up"></i>
                                    <i v-else class="fas fa-arrow-down"></i>
                                </span>
                            </th>
                            <th @click="sortColum('description')">
                                {{ ('description') }}
                                <span>
                                    <i v-if="orderDesc === 'asc' " class="fas fa-arrow-up"></i>
                                    <i v-else class="fas fa-arrow-down"></i>
                                </span>
                            </th>
                            <th>
                                {{ ('estimates') }}
                            </th>
                            <th class="notoggle">{{ ('options') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(task, i) in filteredTasks" :key="task._id">
                            <td @click="selected(task)">{{ filteredTasks[i].title }}</td>
                            <td @click="selected(task)">{{ filteredTasks[i].description }}</td>
                            <td>min:{{filteredTasks[i].min_estimate}}<br> max:{{filteredTasks[i].max_estimate}}</td>
                            <td class="notoggle">
                                <form v-on:submit.prevent="addToQuotation(task)" method="POST"
                                      class="editform">
                                    <button class="btn btn-success"><i class="fas fas fa-plus-circle"></i></button>
                                </form>
                            </td>
                        </tr>
                        <tr v-if="filteredTasks.length === 0">
                            <td>
                                no results found
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-12">
                <selected-events-component v-if="showSelected" :selectedtasks="selectedTasks"
                                           @close="close"></selected-events-component>
            </div>

        </div>
    </div>
</template>

<script>
    import SelectedEventsComponent from "./SelectedEventsComponent";

    export default {
        name: "selecterTask",
        components: {SelectedEventsComponent: SelectedEventsComponent},
        mounted() {
            console.log('SelectTask component mounted.')
            this.getTasks();
        },
        props: {
            data: Array,
            selectedepic: Object,
        },
        data() {
            return {
                filter: "",
                show: false,
                tasks: Array,
                task: Array,
                modalTitle: "",
                count: 0,
                taskForm: {
                    title: '',
                    description: '',
                },
                selectedTask: undefined,
                selectedTasks: [],
                showSelected: false,
                order: 'asc',
                orderDesc: 'asc',
                orderTitle: 'asc',
                orderColum: 'id',
                selectedColum: 'id',
            }
        },
        watch: {
            selectedepic: function () {
                console.log(this.selectedepic);
                this.getTasks();
                // this.count++;
            },
        },
        computed: {
            filteredTasks() {
                const search = this.filter.toLowerCase().trim();
                if (!search) return this.tasks;
                return this.tasks.filter(t => t.title.toLowerCase().indexOf(search) > -1 || t.description.toLowerCase().indexOf(search) > -1);
            },
        },
        methods: {
            getTasks() {
                let epic = this.selectedepic;

                axios.get(route('tasks.getTasksByEpic', epic))
                    .then((res) => {
                        // get all tasks
                        this.tasks = _.orderBy(res.data, this.orderColum, this.order)
                        // get all estimates of task.
                        this.tasks = this.tasks.map(task => {
                            console.log("task", task.id, task);
                            task.min_estimate = 0;
                            task.max_estimate = 0;

                            task.task_estimates = task.task_estimates.map(taskEstimate => {
                                // sum up min and max estimates
                                task.min_estimate += taskEstimate.min_estimate;
                                task.max_estimate += taskEstimate.max_estimate;
                                // TODO: pars minutes to time var

                                return taskEstimate;
                            });

                            task.min_estimate = minutesToTime(task.min_estimate);
                            task.max_estimate = minutesToTime(task.max_estimate);
                            return task;
                        });


                    }).catch((err) => {
                        console.log(err)
                    }
                );
            },
            selected(task) {
                console.log(task.id);
            },
            addToQuotation(task) {
                let _ = this;

                _.showSelected = true;
                if (_.selectedTasks.includes(task)) {
                    this.flash('this task is already added', 'warning', {
                        timeout: 2000,
                        beforeDestroy() {
                        }
                    });
                } else {
                    console.log(task)
                    _.selectedTasks.push(task);
                    this.flash(_.title + ' is added to quotation', 'success', {
                        timeout: 2000,
                        beforeDestroy() {
                        }
                    });
                }
            },
            close() {
                this.showSelected = false;
            },
            sortColum(colum) {
                let that = this;
                if (colum === "title") {
                    if (that.orderTitle === "desc") {
                        that.order = "asc";
                        that.orderTitle = "asc";
                        that.orderDesc = "asc";
                        that.orderColum = colum;
                        that.tasks = _.orderBy(that.tasks, this.orderColum, this.order)
                    } else {
                        that.order = "desc";
                        that.orderTitle = "desc";
                        that.orderDesc = "asc";
                        that.orderColum = colum;
                        that.tasks = _.orderBy(that.tasks, this.orderColum, this.order)
                    }
                }
                if (colum === "description") {
                    if (that.orderDesc === "desc") {
                        that.order = "asc";
                        that.orderTitle = "asc";
                        that.orderDesc = "asc";
                        that.orderColum = colum;
                        that.tasks = _.orderBy(that.tasks, this.orderColum, this.order)
                    } else {
                        that.order = "desc";
                        that.orderTitle = "asc";
                        that.orderDesc = "desc";
                        that.orderColum = colum;
                        that.tasks = _.orderBy(that.tasks, this.orderColum, this.order)
                    }
                }
            },
        }
    }
</script>
