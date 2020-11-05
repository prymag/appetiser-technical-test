<template>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="form-wrapper">
                <Form 
                    @submitted="onFormSubmitted" 
                    :submission_errors="validation_errors" />
                <div class="loading-overlay" v-if="is_loading">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <Calendar :event_name="event_name" :start="date_start" :end="date_end" :days="days_selected"/>
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
            validation_errors: [],
            event_name: null,
            date_start: null,
            date_end: null,
            days_selected: [],
            is_loading: false
        }
    },
    components: {
        Form,
        Calendar
    },
    methods: {
        onFormSubmitted(formData) {
            this.is_loading = true;
            axios.post('/ajax/save-event', formData)
                .then(response => {
                    this.is_loading = false;
                    if (!response.data.success) {
                        return;
                    }
                    this.event_name = response.data.event_info.event_name;
                    this.date_start = new Date(response.data.event_info.date_start);
                    this.date_end = new Date(response.data.event_info.date_end);
                    this.days_selected = response.data.event_info.days_selected;
                }).catch((err) => {
                    this.is_loading = false;
                    if (err.response.data.type == 'validation') {
                        this.validation_errors = err.response.data.errors;
                    }
                });
        }
    }
}
</script>

<style lang="scss" scoped>
.form-wrapper {
    position: relative;

    .loading-overlay {
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: 10;
        background: rgba(0, 0, 0, 0.3);
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        
        .spinner-border {
            position: absolute;
            display: block;
            top:0;
            left:0;
            right:0;
            bottom:0;
            margin: auto;
            z-index: 20;
        }
    }
}
</style>
