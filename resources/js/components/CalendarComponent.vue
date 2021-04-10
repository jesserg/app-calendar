<template>
    <div class="">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h3>Create Events</h3>
                        <form @submit.prevent="submitEvent" class="form">
                            <div class="row clearfix">                              
                                <div class="col-12">
                                    <label>Event</label>
                                    <div class="form-group">
                                        <input v-model="new_event.title" type="text" class="form-control" placeholder="Event title" required>
                                    </div>
                                </div>   
                            </div>
                            <div class="row clearfix">                              
                                <div class="col-6">
                                    <label>From</label>
                                    <div class="form-group">
                                        <input v-model="new_event.date_from" type="date" class="form-control" placeholder="From" required @change="selectDateFrom">
                                    </div>
                                </div>   
                                <div class="col-6">
                                    <label>To</label>
                                    <div class="form-group">
                                        <input v-model="new_event.date_to" type="date" class="form-control" placeholder="To" :min="min_date" required>
                                    </div>
                                </div>  
                            </div>
                            <div class="row clearfix">
                                <div class="col-12">
                                    <div class="form-check form-check-inline">
                                        <input v-model="new_event.monday" class="form-check-input" type="checkbox" id="monday" value="monday">
                                        <label class="form-check-label" for="monday">Mon</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input v-model="new_event.tuesday" class="form-check-input" type="checkbox" id="tuesday" value="tuesday">
                                        <label class="form-check-label" for="tuesday">Tue</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input v-model="new_event.wednesday" class="form-check-input" type="checkbox" id="wednesday" value="wednesday">
                                        <label class="form-check-label" for="wednesday">Wed</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input v-model="new_event.thursday" class="form-check-input" type="checkbox" id="thursday" value="thursday">
                                        <label class="form-check-label" for="thursday">Thu</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input v-model="new_event.friday" class="form-check-input" type="checkbox" id="friday" value="friday">
                                        <label class="form-check-label" for="friday">Fri</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input v-model="new_event.saturday" class="form-check-input" type="checkbox" id="saturday" value="saturday">
                                        <label class="form-check-label" for="saturday">Sat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input v-model="new_event.sunday" class="form-check-input" type="checkbox" id="sunday" value="option1">
                                        <label class="form-check-label" for="sunday">Sun</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-12">
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary" v-if="!saving">Save</button>
                                        <button type="button" class="btn btn-primary" disabled v-if="saving">
                                            <span>Saving...</span>
                                            <div class="spinner-border spinner-border-sm" role="status">
                                                <span class="sr-only">Saving...</span>
                                            </div>
                                        </button>

                                    </div>
                                </div>
                                <div class="col-12" v-if="event_error">
                                    <div class="alert alert-danger mt-4" role="alert">Something went wrong. Please try again later.</div>                       
                                </div>
                                <div class="col-12" v-if="event_success">
                                    <div class="alert alert-success mt-4" role="alert">Event successfully created.</div>                       
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <full-calendar :events="event_data"></full-calendar>
                    </div>
                </div>
            </div>
        </div>   
    </div>
</template>

<script>
    import 'fullcalendar/dist/fullcalendar.css';
    import {FullCalendar} from 'vue-full-calendar';
    import axios from 'axios'
    import moment from 'moment'

    export default {
        components:{
            'full-calendar': FullCalendar,
        },
        data() {
            return {
                event_data : {},
                new_event: {},
                saving: false,
                min_date : '',
                event_error: false,
                event_success: false,
            }
        },
        mounted() {
            this.getEvents();
        },
        methods:{
            getEvents(){
                axios.get('/show-events')
                .then(response => {
                    this.event_data = response.data.event_list
                })
            },
            submitEvent() {
                const formParams = {
                    title: this.new_event.title,
                    start: this.new_event.date_from,
                    end: this.new_event.date_to,
                    monday: this.new_event.monday,
                    tuesday: this.new_event.tuesday,
                    wednesday: this.new_event.wednesday,
                    thursday: this.new_event.thursday,
                    friday: this.new_event.friday,
                    saturday: this.new_event.saturday,
                    sunday: this.new_event.sunday,

                }
                this.saving = true;
                axios.post('/create-events', formParams)
                .then(response => {
                    this.saving = false;
                    //call function get events
                    this.getEvents();
                    //show message
                    this.event_error = false;
                    this.event_success = true;
                    setTimeout(() => {
                        this.event_success = false;
                    }, 5000);
                })
                .catch(error => {
                    this.saving = false;
                    console.log(error);
                    this.event_error = true;
                    this.event_success = false;
                    setTimeout(() => {
                        this.event_error = false;
                    }, 5000);
                })
            },
            selectDateFrom(){
                this.new_event.date_to = null;
                this.min_date = this.new_event.date_from;
            }
        },
        
    }
</script>