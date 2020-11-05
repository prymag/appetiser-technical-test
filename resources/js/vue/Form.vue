<template>
    <div class="form">
        <div class="form-group">
            <label for="">Event Name</label>
            <input type="text" class="form-control" v-model="event_name" />
        </div>
        <div class="d-flex">
            <div class="form-group pr-2">
                <label for="">From</label>
                <datepicker :format="format"
                    :input-class="'form-control'"></datepicker>
            </div>
            <div class="form-group">
                <label for="">To</label>
                <datepicker :format="format"
                    :input-class="'form-control'"></datepicker>
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
        }
    },
    components: {
        Datepicker
    },
    methods: {
        submit() {
            const data = {
                event_name: this.event_name,
                date_start: this.date_start,
                date_end: this.date_end
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
