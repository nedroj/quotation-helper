<!-- todo edit app.js: Vue.component('component-name', require('./components/ComponentName.vue').default);-->
<template>
    <div class="table-responsive table-striped">
        <div class="card ">
            <div class="card-header">Selected component</div>
            <div class="card-body">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>{{ ('epic') }}</th>
                        <th>{{ ('title') }}</th>
                        <th>{{ ('estimates') }}</th>
                        <th class="notoggle">{{ ('options') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(selectedtask, i) in selectedtasks">
                        <td>
                            {{selectedtasks[i].epic.title}}
                        </td>
                        <td>
                            {{selectedtasks[i].title}}
                        </td>
                        <td>
                            min:{{selectedtasks[i].min_estimate}}<br> max:{{selectedtasks[i].max_estimate}}
                        </td>
                        <td class="notoggle">
                            <form v-on:submit.prevent="openModal(selectedtasks[i])">
                                <button class="btn btn-success"><i class="far fa-stopwatch"></i></button>
                            </form>
                            <form v-on:submit.prevent="removeQuotation(selectedtask[i],i)" method="POST"
                                  class="removeform">
                                <button class="btn btn-warning"><i class="fas fas fa-minus-circle"></i></button>
                            </form>
                        </td>

                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <table>
                    <tr>
                        <td>{{Total}}</td>
                        <td></td>
                        <td class="notoggle">
                            <form v-on:submit.prevent="saveQuotation(selectedtasks)" method="POST">
                                <label for="title"></label><input name="title" type="text" id="title" v-model="title">
                                <button>Save</button>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <modal name="taskEstimateModal"
               height="auto"
               scrollable
               width="70%"
               :clickToClose="false">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-10">
                                <h1>customize estimate</h1>
                                <p>Selected task: {{ task.title }}</p>
                                <p>description: {{ task.description }}</p>
                            </div>
                            <div class="col-lg-2">
                            </div>
                        </div>
                        <form method="POST">
                            <div class="row">
                                <table class="table mb-0">
                                    <tbody>
                                    <tr v-for="(estimate, i) in task.task_estimates" :key="estimate.id">
                                        <td>{{ estimate.department_id }}</td>
                                        <td>
                                            <label>
                                                {{baseEstimatesMin(estimate.min_estimate)}}
                                                <br>
                                                {{baseEstimatesMax(estimate.max_estimate)}}
                                            </label>
                                        </td>
                                        <td class="form-group">
                                            <label>{{('Min')}}
                                                <input type="text"
                                                       class="form-control"
                                                       name="min"
                                                       @blur="parseTime(estimate,i)"
                                                       v-model="estimate.new_min_estimate">
                                            </label>
                                        </td>
                                        <td class="form-group">
                                            <label>{{('Max')}}
                                                <input type="text"
                                                       class="form-control"
                                                       name="max"
                                                       @blur="parseTime(estimate)"
                                                        v-model="estimate.new_max_estimate">
                                            </label>
                                        </td>
                                        <td class="form-group">
                                            <label>{{('Comment')}}
                                                <textarea type="text"
                                                          class="form-control"
                                                          name="comment"
                                                          v-model="estimate.comment">
                                                </textarea>
                                            </label>
                                        </td>

                                        <td class="notoggle">
                                            <form v-on:submit.prevent="remove(estimate,i)"
                                                  method="POST"
                                                  class="destroyform">
                                                <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                            </form>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <button @click.prevent="saveChangedEstimates(task.task_estimates)"
                                            style="margin-bottom: 10px;" type="submit" class="btn btn-success">Submit
                                    </button>
                                </div>
                                <div class="col-lg-4">

                                </div>
                                <div class="col-lg-4">
                                    <button style="margin-bottom: 10px;" class="notoggle btn btn-danger"
                                            @click.prevent="hideModal(task.task_estimates)">
                                        decline
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.$modal.hide('estimateModal');
        },
        props: {
            selectedtasks: Array,
        },
        data() {
            return {
                title: "",
                task: {
                    task_estimates: []
                },
                estimates: [],
                modalsFilled: [],
            }
        },

        computed: {
            Total: function () {
                let totalMin = 0;
                let totalMax = 0;
                let totalMinTemp = 0;
                let totalMaxTemp = 0;
                this.selectedtasks.forEach(task => {
                    //  next foreach loop is needed
                    task.task_estimates.forEach(estimate =>{
                        estimate.NewMaxEstimate = estimate.min_estimate;
                        estimate.NewMinEstimate = estimate.max_estimate;
                    })
                    totalMinTemp = timeToMinutes(task.min_estimate)
                    totalMaxTemp = timeToMinutes(task.max_estimate)
                    totalMin += totalMinTemp;
                    totalMax += totalMaxTemp;
                })

                totalMin = minutesToHour(totalMin);
                totalMax = minutesToHour(totalMax);

                return "min: " + totalMin + " max: " + totalMax;

            },
        },
        methods: {
            removeQuotation(task, i) {
                console.log(i);
                let _ = this;
                this.flash('task has been removed', 'warning', {
                    timeout: 2000,
                    beforeDestroy() {
                    }
                });
                _.selectedtasks.splice(_.selectedtasks.indexOf(_.selectedtasks, task));
                if (_.selectedtasks.length <= 0) {
                    this.$emit("close");
                }
            },
            baseEstimatesMax(max) {
                let basemax = 0;
                basemax = minutesToHour(max);

                return "Base max: " + basemax;
            },
            baseEstimatesMin(min) {
                let basemin = 0;
                basemin = minutesToHour(min);

                return "Base min: " + basemin;
            },
            saveQuotation() {
                axios.post(route('quotations.store'), {
                    'selectedItems': this.selectedtasks,
                    'title': this.title,
                    'status': '1'
                }).then((response) => {
                    if (response.status === 200) {
                        this.flash('quotation has been created', 'success', {
                            timeout: 2000,
                            beforeDestroy() {
                            }
                        });
                        location.href = '/projects';
                    } else this.flash('something went wrong', 'error', {
                        timeout: 2000,
                        beforeDestroy() {
                        }
                    });
                }).catch((response) => {
                    console.log(response);
                    console.log('something went wrong: ', response);
                    this.flash('something went wrong', 'error', {
                        timeout: 2000,
                        beforeDestroy() {
                        }
                    });
                });
            },
            openModal(task) {
                console.log("selectedTaks ", this.selectedtasks)

                this.$modal.show('taskEstimateModal');
                this.task = Object.assign({}, task);

            },
            hideModal(taskEst) {
                taskEst.forEach(estimate =>{
                    estimate.new_max_estimate = "0m";
                    estimate.new_min_estimate = "0m";
                    estimate.comment = '';
                })
                this.$modal.hide('taskEstimateModal');

            },
            parseTime(estimate) {
                //this function wil set the string of time back to minutes and reconvert the minutes to sting.
                estimate.new_max_estimate = minutesToTime(timeToMinutes(estimate.new_max_estimate));
                estimate.new_min_estimate = minutesToTime(timeToMinutes(estimate.new_min_estimate));

                let min_est = timeToMinutes(estimate.new_min_estimate)
                let max_est = timeToMinutes(estimate.new_max_estimate)
                if (min_est <= 0 && max_est <= 0){
                    estimate.new_min_estimate = estimate.min_estimate;
                    estimate.new_max_estimate = estimate.max_estimate;
                }
                if (min_est > max_est){
                    console.log("max is lower than min this isn't possible");
                }else{
                    estimate.new_max_estimate = minutesToTime(max_est);
                    estimate.new_min_estimate = minutesToTime(min_est);
                }

                // console.log(this.task);

            },
            remove(estimate){
                estimate.new_max_estimate = "0m";
                estimate.new_min_estimate = "0m";
                estimate.comment = '';

            },
            saveChangedEstimates(taskEst) {
                let _ = this;
                let errorCount = 0;
                taskEst.forEach(estimate =>{
                    let min_est = timeToMinutes(estimate.new_min_estimate)
                    let max_est = timeToMinutes(estimate.new_max_estimate)
                    if (min_est <= 0 || max_est <= 0){
                        estimate.new_min_estimate = estimate.min_estimate;
                        estimate.new_max_estimate = estimate.max_estimate;
                    }
                    if (min_est > max_est){
                        errorCount++;
                        console.log("max is lower than min this isn't possible");
                    }else{

                        estimate.new_max_estimate = minutesToTime(max_est);
                        estimate.new_min_estimate = minutesToTime(min_est);
                        estimate.NewMaxEstimate = max_est;
                        estimate.NewMinEstimate = min_est;

                    }
                })
                // logging after click on save button
                console.log(taskEst);
                if (errorCount <= 0) {
                    this.$modal.hide('taskEstimateModal');
                    this.flash('changes were made to the estimates', 'success', {
                        timeout: 2000,
                        beforeDestroy() {
                        }
                    });
                }else {
                    this.flash('there is something wrong with the fields that are edited', 'warning', {
                        timeout: 2000,
                        beforeDestroy() {
                        }
                    });
                }
            }
        },
    }
</script>
