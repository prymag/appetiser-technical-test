<template>
    <div>
        <a href="#" @click="prevMonth">Prev</a> {{monthName}} <a href="#" @click="nextMonth">Next</a>
        <div class="days d-flex flex-column">
            <div class="day border d-flex flex-row" v-for="(day, index) in daysInMonth"
                v-bind:key="index">
                <div class="date-info p-3 bg-secondary" v-html="formatDate(day)">
                </div>
                <div class="event-info p-3">
                    <span v-if="isDayInEvent(day)">
                        {{event_name}}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Calendar',
    props: ['date', 'event_dates', 'event_name'],
    data() {
        return {
            the_date:'',
            the_events: ['2020-11-01'],
        }
    },
    methods: {
        isDayInEvent(date) {
            if (!this.event_dates) {
                return false;
            }

            const year = date.getFullYear();
            const month = date.getMonth() + 1; // Count starts at 0
            const day = ('0' + date.getDate()).slice(-2); // convert to two digits

            return this.event_dates.indexOf(`${year}-${month}-${day}`) !== -1;
        },
        prevMonth(e) {
            e.preventDefault();
            this.the_date = new Date(this.the_date.getFullYear(), this.the_date.getMonth() - 1, 1);
        },
        nextMonth(e) {
            e.preventDefault();
            this.the_date = new Date(this.the_date.getFullYear(), this.the_date.getMonth() + 1, 1);
            console.log('Called');
        },
        formatDate(date) {
            const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            return `<span class="date">${date.getDate()}</span> 
                <span class="day">${days[date.getDay()]}</span>`;
        },
        getLastDayOfMonth(date) {
            return new Date(date.getFullYear(), date.getMonth() + 1, 0);
        },
        getFirstDayOfMonth(date) {
            return new Date(date.getFullYear(), date.getMonth(), 1);
        },
        createDays(date_start, date_end) {
            const days = new Array(),
            dt = new Date(date_start);

            while (dt <= date_end) {
                days.push(new Date(dt));
                dt.setDate(dt.getDate() + 1);
                dt.setHours(0, 0, 0, 0);
            }

            return days;
        }
    },
    computed: {
        monthName: function() {
            if (!this.$props.date && this.the_date == '') {
                this.the_date = new Date();
            }

            const monthName = this.the_date.toLocaleString('default', { month: 'long' });
            return monthName;
        },
        daysInMonth: function() {
            const start = this.getFirstDayOfMonth(this.the_date);
            const end = this.getLastDayOfMonth(this.the_date);

            const days = this.createDays(start, end);
            return days;
        }
    }
}
</script>

<style lang="scss" scoped>
.days {
    .date-info {
        width: 15%;
        color: #ffffff;
    }
}
</style>