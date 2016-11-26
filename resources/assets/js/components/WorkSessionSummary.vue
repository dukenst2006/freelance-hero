<template>
    <div>
        <div class="row col-sm-12">
            <div class="form-group col-sm-3">
                <label for="date_start">From</label>
                <date-picker v-on:change="updateResults" :date="date_start" :option="option"></date-picker>
            </div>
            <div class="form-group col-sm-3">
                <label for="date_end">Until</label>
                <date-picker v-on:change="updateResults" :date="date_end" :option="option"></date-picker>
            </div>
        </div>
        <div class="row col-sm-12">
            <div class="col-sm-12">
                <button v-on:click="setTimeframe('weekly')" v-bind:class="{ active: weeklyView }" class="btn btn-default" type="button">Weekly</button>
                <button v-on:click="setTimeframe('monthly')" v-bind:class="{ active: monthlyView }" class="btn btn-default" type="button">Monthly</button>
                <button v-on:click="setTimeframe('biMonthly')" v-bind:class="{ active: biMonthlyView }" class="btn btn-default" type="button">Bi-Monthly</button>
            </div>
        </div>
        <div class="row col-sm-12">
            <div class="col-sm-12">
                <p>&nbsp;</p>
                <p v-show="results" v-for="result in results">
                    {{ result.name }}: {{ result.total_time }} hr(s)
                </p>
                <p v-show="results == false">No completed work sessions.</p>
            </div>
        </div>
    </div>
</template>

<script>
    import myDatepicker from 'vue-datepicker';

    export default {
        mounted: function() {
            this.setTimeframe('monthly');
        },

        data: function() {
            return {
                results: false,
                date_start: {
                    time: ''
                },
                date_end: {
                    time: ''
                },
                option: {
                    type: 'day',
                    week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                    month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    format: 'YYYY-MM-DD',
                    inputStyle: {
                        'display': 'block',
                        'width': '100%',
                        'height': '34px',
                        'padding': '6px 12px',
                        'font-size': '14px',
                        'line-height': '1.428571429',
                        'color': '#555555',
                        'background-color': '#fff',
                        'background-image': 'none',
                        'border': '1px solid #ccc',
                        'border-radius': '4px',
                        'box-shadow': 'inset 0 1px 1px rgba(0, 0, 0, 0.075)',
                        '-webkit-transition': 'border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s',
                        'transition': 'border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s',
                    }
                }
            };
        },

        components: {
            'date-picker': myDatepicker
        },

        methods: {
            getResults: function() {
                this.$http.get('/work_sessions/summary?date_start=' + this.date_start.time + '&date_end=' + this.date_end.time + '&timeframe=')
                        .then(response => {
                            if ( response.body.length ) {
                                this.results = response.body;
                            } else {
                                this.results = false;
                            }
                        });
            },

            updateResults: function() {
                this.weeklyView = false;
                this.monthlyView = false;
                this.biMonthlyView = false;

                this.getResults();
            },

            setTimeframe: function(timeframe) {
                var today = new Date();
                this.date_end.time = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate();

                switch(timeframe) {
                    case 'weekly':
                        this.weeklyView = true;
                        this.monthlyView = false;
                        this.biMonthlyView = false;
                        this.date_start.time = this.getWeekStart(today);
                        break;
                    case 'monthly':
                        this.weeklyView = false;
                        this.monthlyView = true;
                        this.biMonthlyView = false;
                        this.date_start.time = this.getMonthStart(today);
                        break;
                    case 'biMonthly':
                        this.weeklyView = false;
                        this.monthlyView = false;
                        this.biMonthlyView = true;
                        this.date_start.time = this.getBiMonthStart(today);
                        break;
                }
                this.getResults();
            },

            getWeekStart: function(today) {
                var day = today.getDay();
                var diff = today.getDate() - day + (day == 0 ? -6 : 1);
                var newDate = new Date(today.setDate(diff));
                return newDate.getFullYear() + "-" + (newDate.getMonth() + 1) + "-" + newDate.getDate();
            },

            getMonthStart: function(today) {
                return today.getFullYear() + "-" + (today.getMonth() + 1) + "-01";
            },

            getBiMonthStart: function(today) {
                if ( today.getDate() >= 16 ) {
                    return today.getFullYear() + "-" + (today.getMonth() + 1) + "-16";
                } else {
                    return today.getFullYear() + "-" + (today.getMonth() + 1) + "-01";
                }
            }
        }
    }
</script>