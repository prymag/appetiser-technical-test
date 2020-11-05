<template>
    <div>
        <div class="nav d-flex align-items-center justify-content-center">
            <a href="#" class="prev" @click="prevMonth">&laquo;</a> 
            <h3 class="mb-0">{{monthName}} {{the_date.getFullYear()}}</h3>
            <a href="#" class="next" @click="nextMonth">&raquo;</a>
        </div>
        <div class="days d-flex flex-column">
            <div class="alert alert-info" v-if="start && end">
                <h6><span class="flex-fill">Event: {{ event_name }}</span></h6>
                <div class="d-flex flex-row">
                    <span class="flex-fill">From: {{ eventStart }}</span>
                    <span class="flex-fill">To: {{ eventEnd }}</span>
                </div>
            </div>
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
    props: ['event_name', 'start', 'end', 'days'],
    data() {
        return {
            the_date:'',
        }
    },
    created() {
        if (!this.$props.start && !this.$props.end) {
            this.the_date = new Date();
            this.the_date.setHours(0, 0, 0);
        }

        if (this.$props.start) {
            this.$props.start.setHours(0, 0, 0);
            this.the_date = new Date(this.$props.start.getFullYear(), this.$props.start.getMonth(), 1);
        }

        if (this.$props.end) {
            this.$props.end.setHours(0,0,0);
        }
    },
    methods: {
        isDayInEvent(date) {
            if (!this.$props.days || date < this.$props.start || date > this.$props.end) {
                return false;
            }

            const day_str = this.getDayString(date);
            return this.$props.days.indexOf(day_str) !== -1;
        },
        prevMonth(e) {
            e.preventDefault();
            this.the_date = new Date(this.the_date.getFullYear(), this.the_date.getMonth() - 1, 1);
        },
        nextMonth(e) {
            e.preventDefault();
            this.the_date = new Date(this.the_date.getFullYear(), this.the_date.getMonth() + 1, 1);
        },
        toHumanDate(date) {
            const months = [
                'January', 'February', 'March', 'April', 
                'May', 'June', 'July', 'August',
                'September', 'October', 'November', 'December'
            ];

            return `${months[date.getMonth()]} ${date.getDate()} ${date.getFullYear()}`;
        },
        formatDate(date) {
            return `<span class="date">${date.getDate()}</span> 
                <span class="day">${this.getDayString(date)}</span>`;
        },
        getDayString(date) {
            const days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
            return days[date.getDay()];
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
            const monthName = this.the_date.toLocaleString('default', { month: 'long' });
            return monthName;
        },
        daysInMonth: function() {
            const start = this.getFirstDayOfMonth(this.the_date);
            const end = this.getLastDayOfMonth(this.the_date);

            const days = this.createDays(start, end);
            return days;
        },
        eventStart: function() {
            return this.toHumanDate(this.$props.start);
        },
        eventEnd: function() {
            return this.toHumanDate(this.$props.end);
        }
    }
}
</script>

<style lang="scss" scoped>
.nav {
    margin-bottom: 20px;
    .prev,
    .next {
        width: 20px;
        height: 20px;
        line-height: 20px;
        color: #ffffff;
        background: #343a40;
        text-align: center;
        margin:0 10px;
        text-decoration: none;
    }
    h3 {
        display: block;
        width: 250px;
        text-align:center;
    }
}
::v-deep .days {
    .date-info {
        width: 15%;
        color: #ffffff;

        .day {
            text-transform: capitalize;
        }
    }
}
</style>