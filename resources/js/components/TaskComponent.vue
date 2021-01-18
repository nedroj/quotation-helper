<template>
<!--    This file will open when there is an epic selected -->
    <div class="col-lg-12">
        <div class="table-responsive table-striped">
            <h4 class="header-title">{{ ('Manage tasks') }}
                <button @click.prevent="showModalAdd"
                        class="btn btn-primary float-right">
                    <i class="fas fa-plus-circle"></i> {{ ('Add task') }}
                </button>
            </h4>
            <p>Selected epic: {{ selectedepic.title }}</p>
            <p>description: {{selectedepic.description}}</p>

            <table class="table mb-0">
                <thead>
                <tr>
                    <th>{{ ('title') }}</th>
                    <th>{{ ('description') }}</th>
                    <th class="notoggle">{{ ('options') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="task in tasks">
                    <td @click="selected(task)">{{ task.title }}</td>
                    <td @click="selected(task)">{{ task.description }}</td>
                    <td class="notoggle">
                        <form v-on:submit.prevent="showModalEdit(task)" method="POST"
                              class="editform">
                            <button class="btn btn-warning"><i class="far fa-edit"></i></button>
                        </form>
                        <form v-on:submit.prevent="remove(task)"
                              method="POST"
                              class="destroyform">
                            <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                        </form>
                        <form v-on:submit.prevent="showEstimate(task)"
                              method="POST"
                              class="estimateform">
                            <button class="btn btn-success"><i class="far fa-stopwatch"></i></button>
                        </form>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!--        <ul>-->
        <!--            <li v-for="task in tasks">test</li>-->
        <!--        </ul>-->
        <modal name="taskModal"
               height="auto">
            <div class="container-fluid">
                <form method="POST" v-on:submit.prevent="task ? update(task) : create()">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="title">{{('title')}}</label>
                                <input type="text"
                                       class="form-control"
                                       id="title"
                                       name="title"
                                       v-model="taskForm.title">
                                <!--                                                    @error('Title') is-invalid @enderror"-->
                                <!--                                <p v-if="titError">{{titError}}</p>-->
                            </div>
                            <div class="form-group">
                                <label for="description">{{('description')}}</label>
                                <input type="text"
                                       class="form-control"
                                       id="description"
                                       name="description"
                                       v-model="taskForm.description">
                                <!--                                               :value="selectedEpic ? (selectedEpic.description) : ('description')"-->
                                <!--                                                    @error('Description') is-invalid @enderror-->
                                <!--                                <p v-if="descError">{{descError}}</p>-->
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4" style="align-content: end">
                            <button style="margin-bottom: 10px;" class="notoggle btn btn-danger"
                                    @click.prevent="hideModal">
                                {{('discard')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </modal>
<!--        This will open EstimatesComponent.vue when the green button with the timer is clicked.  -->
        <estimate-component v-if="selectedTask" :selectedtask="selectedTask" @close="close"></estimate-component>
    </div>
</template>


<script>
    import EstimateComponent from "./EstimateComponent";

    export default {
        name: "tasks",
        components: {EstimateComponent},
        mounted() {
            console.log('Task component mounted.');
            this.getTasks();
        },
        props: {
            data: Array,
            selectedepic: Object,
        },
        data() {
            return {
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
            }
        },
        watch: {
            selectedepic: function () {
                console.log(this.selectedepic);
                this.getTasks();
                this.count++;
            }
        },
        methods: {
            getTasks() {
                this.tasks = "";
                let epic = this.selectedepic;
                axios.get(route('tasks.getTasksByEpic', epic))
                    .then((res) => {
                        this.tasks = res.data;
                        console.log(this.count)
                    }).catch((err) => {
                    console.log(err)
                });
            },
            //modal functions
            showModalEdit(task) {
                if (task) {
                    this.task = task;
                    this.modalTitle = "Edit Task";
                    this.taskForm.title = task.title;
                    this.taskForm.description = task.description;
                } else {
                    this.hideModal();
                    this.showModalAdd();
                }
                this.$modal.show('taskModal');
            },
            showModalAdd() {
                this.task = false;
                this.modalTitle = "New task";
                this.taskForm.title = "";
                this.taskForm.description = "";
                this.$modal.show('taskModal');
            },
            showEstimate(task) {
                console.log("selected task:", task);
                // this.$emit("inputtask", task);
                this.selectedTask = task;
                // const payload ={
                //     task: this.task
                // }
            },
            hideModal() {
                this.$modal.hide('taskModal');
            },
            create() {
                let that = this;
                axios.post(route('tasks.store'), {
                    'epic_id': this.selectedepic.id,
                    'title': this.taskForm.title,
                    'description': this.taskForm.description
                }).then((response) => {
                    if (response.status === 200) {
                        this.flash('Task has been created', 'success', {
                            timeout: 2000,
                            beforeDestroy() {
                            }
                        });
                        // console.log(response);
                        that.tasks.push(this.taskForm);
                        this.hideModal();
                        this.getTasks();
                    } else this.flash('Something went wrong', 'error', {
                        timeout: 2000,
                        beforeDestroy() {
                        }
                    });
                }).catch((err) => {
                    this.flash('Invalid values ' + err.response.data.errors, 'error', {
                        timeout: 2000,
                        beforeDestroy() {
                        }
                    });

                    console.log(err);
                    console.log('something went wrong: ', err.response.data.errors);
                    that.titError = err.response.data.errors.title;
                    that.descError = err.response.data.errors.description;
                });
            },
            update(task) {
                let that = this;

                axios.post(route('tasks.update', this.task), {
                    '_method': 'PATCH',
                    'title': this.taskForm.title,
                    'description': this.taskForm.description,
                }).then((response) => {
                    if (response.status === 200) {
                        this.flash('Task has been updated', 'success', {
                            timeout: 2000,
                            beforeDestroy() {
                            }
                        });
                        this.hideModal();
                        this.getTasks();

                    } else this.flash('Something went wrong', 'error', {
                        timeout: 2000,
                        beforeDestroy() {
                        }
                    });
                }).catch((error) => {
                    if (error.response) {
                        console.log(error.response.data);
                        console.log(error.response.status);
                        console.log(error.response.headers);
                    }
                });

            },
            remove(task) {
                let that = this;
                // console.log('delete', epic);
                axios.post(route('tasks.destroy', task), {
                    '_method': 'DELETE'
                }).then(function (response) {
                    if (response.status === 200) {
                        that.tasks.splice(that.tasks.indexOf(task), 1);
                        // console.log(response);
                        this.flash('Task ' + task.title + ' has been deleted', 'success', {
                            timeout: 2000,
                            beforeDestroy() {
                            }
                        });
                    } else this.flash('Something went wrong', 'error', {
                        timeout: 2000,
                        beforeDestroy() {
                        }
                    });
                }).catch((error) => {
                    if (error.response) {
                        console.log(error.response.data);
                        console.log(error.response.status);
                        console.log(error.response.headers);
                    }
                });
            },
            selected(task) {
                console.log(task.id);

            },
            close() {
                this.selectedTask = undefined;
            },
            submit: function () {
                this.$emit("inputdata", this.tempMessage);
                console.log(this.tempMessage);
                this.tempMessage = "";
            },
        }

    }
</script>
