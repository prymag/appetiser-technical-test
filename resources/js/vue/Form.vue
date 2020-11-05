<template>
    <div class="form">

        <div class="alert alert-danger" v-if="errors.length">
            <ul>
                <li v-for="(error, index) in errors" :key="index">{{error}}</li>
            </ul>
        </div>

        <div class="form-group">
            <label for="">Event Name</label>
            <input type="text" class="form-control" v-model="event_name" />
        </div>
        <div class="d-flex">
            <div class="form-group pr-2">
                <label for="">From</label>
                <datepicker :format="format"
                    v-model="date_start"
                    :input-class="'form-control'"></datepicker>
            </div>
            <div class="form-group">
                <label for="">To</label>
                <datepicker :format="format"
                    v-model="date_end"
                    :input-class="'form-control'"></datepicker>
            </div>
        </div>
        <strong>Days</strong>
        <div class="d-flex flex-wrap">
            <div class="form-check p-3 mr-2" v-for="day in days"
                v-bind:key="day">
                <input class="form-check-input" 
                    type="checkbox" 
                    name="days"  
                    v-model="days_selected"
                    :value="day" 
                    :id="`day_${day}`"/>
                <label class="form-check-label" :for="`day_${day}`">{{day}}</label>
            </div>
        </div>
        <button @click="submit">Submit</button>
    </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';

export default {
    name: 'Form',
    data() {
        return {
            event_name: 'The name',
            date_start: '',
            date_end: '',
            format: "yyyy-MM-dd",
            days: ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'],
            days_selected: [],
            is_valid: true,
            errors: []
        }
    },
    components: {
        Datepicker
    },
    methods: {
        validate() {
            this.errors = [];

            if (this.event_name == '') {
                this.is_valid = false;
                this.errors.push('Please enter an event name');
            }

            if (this.date_start == '') {
                this.is_valid = false;
                this.errors.push('Please select a from date');
            }

            if (this.date_end == '') {
                this.is_valid = false;
                this.errors.push('Please select a to date');
            }

            if (this.date_start && this.date_end) {
                const start = new Date(this.date_start);
                const end = new Date(this.date_end);

                if (start > end) {
                    this.errors.push('The start date is greater than the end date');
                    this.is_valid = false;
                }
            }

            if (!this.days_selected.length) {
                this.is_valid = false;
                this.errors.push('Please select atleast one day');
            }
        },
        submit() {
            this.validate();

            if (!this.is_valid) {
                return;
            }

            const data = {
                event_name: this.event_name,
                date_start: this.date_start,
                date_end: this.date_end,
                days_selected: this.days_selected
            }
            this.$emit('submitted', data);
        },
        formatDate(date) {
            // Date is formatted as YYYY/MM/DD
            // change the slash to dash
            return date.replace(/\//g, '-');
        },
        onDateStartChanged(date) {
            this.date_start = this.formatDate(date);
        },
        onDateEndChanged(date) {
            this.date_end = this.formatDate(date);
        }
    }
}
</script>
