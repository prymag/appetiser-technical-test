<template>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <Form @submitted="onFormSubmitted"/>
        </div>
        <div class="col-md-8">
            <Calendar :event_name="event_name" :start="range_start" :end="range_end" :days="days"/>
        </div>
    </div>
</div>
    
</template>

<script>
import Form from './Form';
import Calendar from './Calendar';

export default {
    name: 'App',
    data() {
        return {
            event_name: 'Test',
            range_start: new Date('2020-10-01'),
            range_end: new Date('2020-12-05'),
            days: ['sun', 'mon', 'wed']
        }
    },
    components: {
        Form,
        Calendar
    },
    methods: {
        onFormSubmitted(formData) {
            axios.get('/ajax/save-event').then(result => {
                this.event_name = 'Testing';
                this.event_dates = ['2020-11-01', '2020-11-13'];
            });
            console.log(formData);
        }
    }
}
</script>

<style>
#advanced_search {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: #2c3e50;
}
</style>
