<template>
<!--    This file will open when the green button is clicked op the manage tasks component-->
    <modal name="estimateModal"
           id="modal-scrollable"
           height="auto"
           scrollable
           :clickToClose="false">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1>estimate</h1>
                            <p>Selected task: {{ selectedtask.title }}</p>
                            <p>description: {{ selectedtask.description }}</p>
                        </div>
                    </div>

                    <form method="POST" v-on:submit.prevent="estimate ? update(estimate) : store()">
                        <div class="row">
                            <table class="table mb-0">
                                <thead></thead>
                                <tbody>
                                <tr v-for="(estimate, i) in estimates" :key="estimate._id">
                                    <td>{{ estimate.department.name }}</td>
                                    <td class="form-group">
                                        <label>{{('min')}}</label>
                                        <input type="text"
                                               class="form-control"
                                               name="min"
                                               min="0"
                                               @blur="parseTime(estimates[i])"
                                               v-model="estimates[i].min_estimate">
                                    </td>
                                    <td class="form-group">
                                        <label>{{('max')}}</label>
                                        <input type="text"
                                               class="form-control"
                                               min="0"
                                               name="max"
                                               @blur="parseTime(estimates[i])"
                                               v-model="estimates[i].max_estimate">
                                    </td>
                                    <td class="notoggle">
                                        <form v-on:submit.prevent="remove(estimates[i],i)"
                                              method="POST"
                                              class="destroyform">
                                            <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-4">
                                <button style="margin-bottom: 10px;" type="submit" class="btn btn-success"
                                        @click.prevent="saveAll(estimates)">
                                    {{('Save')}}
                                </button>
                            </div>
                            <div class="col-lg-4">

                            </div>
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
</template>

<script>
    export default {
        name: "estimates",
        mounted() {
            console.log('Estimate component mounted.');
            this.showModal();
        },
        props: {
            data: Array,
            selectedtask: Object,
        },
        data() {
            return {
                departments: [],
                estimates: [],
                estimate: [],
                show: false,
                selectedTime: '',
                task: '',
                modalTitle: "",
                estimateForm: {
                    max_h_estimate: '',
                    max_m_estimate: '',
                    min_h_estimate: '',
                    min_m_estimate: '',
                },
                hours: 0,
                restminutes: 0,
                time: 555,
                newtime: [],
            }
        },
        computed: {},
        watch: {},
        methods: {
            showModal() {
                axios.get(route('taskEstimates.show', this.selectedtask)).then((res) => {
                    this.estimates = res.data;
                    for (let i = 0; this.estimates.length > i; i++) {
                        // console.log(this.estimates[i].max_estimate);
                        this.estimates[i].max_estimate = minutesToTime(this.estimates[i].max_estimate)
                        this.estimates[i].min_estimate = minutesToTime(this.estimates[i].min_estimate)
                        // this.parseTime(this.estimates[i]);
                    }
                    // console.log(this.estimates);
                }).catch((err) => {
                    console.log(err)
                });

                this.$modal.show('estimateModal');
            },
            hideModal() {
                this.$modal.hide('estimateModal');
                this.$emit("close");
            },
            remove(estimate, index) {
                let that = this;
                axios.post(route('taskEstimates.destroy', estimate), {
                    '_method': 'DELETE'
                }).then(function (response) {
                    if (response.status === 200) {
                        // console.log(that.estimates);
                        that.estimates[index].max_estimate = "0m";
                        that.estimates[index].min_estimate = "0m";
                        // console.log(response);
                        this.flash('estimate ' + estimate.name + ' has been reset to 0', 'success', {
                            timeout: 2000,
                            beforeDestroy() {
                            }
                        });
                    } else this.flash('something went wrong', 'error', {
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
                // this wl set a temporally massage on submit
                this.$emit("inputdata", this.tempMessage);
                // console.log(this.tempMessage);
                this.tempMessage = "";
            },
            parseTime(estimate) {
                //this function wil set the string of time back to minutes and reconvert the minutes to sting.
                estimate.max_estimate = minutesToTime(timeToMinutes(estimate.max_estimate));
                estimate.min_estimate = minutesToTime(timeToMinutes(estimate.min_estimate));
            },
            saveAll(estimates) {
                let that = this;
                estimates.forEach(estimate => {
                    estimate.maxEstimate = timeToMinutes(estimate.max_estimate);
                    estimate.minEstimate = timeToMinutes(estimate.min_estimate);
                })
                axios.post(route('taskEstimates.update', this.selectedtask), {
                    '_method': 'PATCH',
                    'estimates': estimates,
                }).then((response) => {
                    if (response.status === 200) {
                        this.flash('estimate has been updated', 'success', {
                            timeout: 2000,
                            beforeDestroy() {
                            }
                        });
                    } else this.flash('something went wrong', 'error', {
                        timeout: 2000,
                        beforeDestroy() {
                        }
                    });
                }).catch((err) => {
                    console.log(err);
                    console.log('something went wrong 2: ', err.response.data);
                });
            }
        },
    }
</script>
