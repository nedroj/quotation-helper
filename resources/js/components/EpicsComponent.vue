<template>
    <!-- epic Management component starts here EpicsComponent.vue-->
    <div class="col-lg-12 row card-box">
        <div class="col-lg-4">
            <div class="table-responsive table-striped">
                <h4 class="header-title">{{ ('Manage epics') }}
                    <button @click.prevent="showModalAdd"
                            class="btn btn-primary float-right">
                        <i class="fas fa-plus-circle"></i> {{ ('Add epic') }}
                    </button>
                </h4>

                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>{{ ('title') }}</th>
                        <!--                    <th>{{ ('description') }}</th>-->
                        <th class="notoggle">{{ ('options') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="epic in epics">
                        <td @click="select(epic)">{{ epic.title }}</td>
                        <!--                    <td @click="select(epic)">{{ epic.description }}</td>-->
                        <td class="notoggle">
                            <form v-on:submit.prevent="showModalEdit(epic)" method="POST"
                                  class="editform">
                                <button class="btn btn-warning"><i class="far fa-edit"></i></button>
                            </form>
                            <form v-on:submit.prevent="remove(epic)"
                                  method="POST"
                                  class="destroyform">
                                <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- use the modal component, pass in the prop -->
            <modal name="epicModal"
                   height="auto">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1>{{epic ? ('Edit epic') : ('Add epic')}}</h1>
                            <form method="POST" v-on:submit.prevent="epic ? update(epic) : store()">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="title">{{('title')}}</label>
                                            <input type="text"
                                                   class="form-control"
                                                   id="title"
                                                   name="title"
                                                   v-model="epicForm.title">
                                            <!--                                                    @error('Title') is-invalid @enderror"-->
                                            <p v-if="titError">{{titError}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">{{('description')}}</label>
                                            <input type="text"
                                                   class="form-control"
                                                   id="description"
                                                   name="description"
                                                   v-model="epicForm.description">
                                            <!--                                               :value="selectedEpic ? (selectedEpic.description) : ('description')"-->
                                            <!--                                                    @error('Description') is-invalid @enderror-->
                                            <p v-if="descError">{{descError}}</p>
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
                    </div>
                </div>
            </modal>
        </div>
        <div class="col-lg-8">
<!--            If an epic is selected Task component will open TaskComponent.vue -->
            <task-component v-if="selectedEpic" :selectedepic="selectedEpic"></task-component>
        </div>
    </div>
</template>

<script>
    import TaskComponent from "./TaskComponent";

    export default {
        name: "epics",
        components: {TaskComponent},
        mounted() {
            console.log('Epic component mounted.');
            this.epic = false;
            this.getAllEpics();
        },
        props: {
            data: Array,
        },
        data() {
            return {
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
            }
        },
        methods: {
            getAllEpics() {
                axios
                    .get(route('epics.index')).then((res) => {
                    this.epics = res.data
                }).catch((err) => {
                    console.log(err)
                });
            },
            remove(epic) {
                let that = this;
                var tempTitle = epic.title;
                axios.post(route('epics.destroy', epic), {
                    '_method': 'DELETE'
                }).then((response) => {
                    if (response.status === 200) {
                        that.epics.splice(that.epics.indexOf(epic), 1);
                        this.flash('Epic has been deleted', 'warning', {
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
            update() {
                let that = this;
                // console.log(this.epic.id, 'update', this.epicForm);
                axios.post(route('epics.update', this.epic), {
                    '_method': 'PATCH',
                    'title': this.epicForm.title,
                    'description': this.epicForm.description,
                }).then((response) => {
                    if (response.status === 200) {
                        this.flash('Epic has been updated', 'success', {
                            timeout: 2000,
                            beforeDestroy() {
                            }
                        });
                        this.hideModal();
                        this.getAllEpics();

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
            submit: function () {
                this.$emit("inputdata", this.tempMessage);
                console.log(this.tempMessage);
                this.tempMessage = "";
            },
            select(epic) {
                console.log('selected epic: ', epic);
                this.selectedEpic = epic;
            },
            store() {
                let that = this;
                // console.log('store');
                axios.post(route('epics.store'), {
                    'title': this.epicForm.title,
                    'description': this.epicForm.description
                }).then((response) => {
                        if (response.status === 200) {
                            this.flash('Epics has been added', 'success', {
                                timeout: 2000,
                                beforeDestroy() {
                                }
                            });
                            that.epics.push(this.epicForm);
                            this.hideModal();
                            this.getAllEpics();
                        } else {
                            this.flash('Something went wrong', 'error', {
                                timeout: 2000,
                                beforeDestroy() {
                                }
                            });
                        }
                    }
                ).catch((err) => {
                    this.flash('Something went wrong: ' + err.response.data.errors, 'error', {
                        timeout: 2000,
                        beforeDestroy() {
                        }
                    });
                    console.log(err);
                    console.log('Something went wrong: ', err.response.data.errors);
                    that.titError = err.response.data.errors.title;
                    that.descError = err.response.data.errors.description;
                });

            },
            showModalAdd() {
                // console.log('open modal add');
                this.epic = '';
                this.epicForm.title = '';
                this.epicForm.description = '';

                this.$modal.show('epicModal');
            },
            showModalEdit(epic) {
                // console.log('open modal', epic);
                if (epic) {
                    this.epic = epic;
                    this.epicForm.title = epic.title;
                    this.epicForm.description = epic.description;
                } else {
                    this.hideModal();
                    this.showModalAdd();
                }

                this.$modal.show('epicModal');
            },
            hideModal() {
                // console.log('close modal');
                this.epic = '';
                this.$modal.hide('epicModal');
            },
            epicSearch() {

            }
        },
    }
</script>
