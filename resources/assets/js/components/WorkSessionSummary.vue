<template>
    <div>
        <div class="row">
            <div class="form-group col-sm-3">
                <label for="date_start">From</label>
                <date-picker v-on:change="getResults" :date="date_start" :option="option"></date-picker>
            </div>
            <div class="form-group col-sm-3">
                <label for="date_end">Until</label>
                <date-picker v-on:change="getResults" :date="date_end" :option="option"></date-picker>
            </div>
        </div>
        <div class="row">
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
            this.prepareComponent();
            this.getResults();
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
                },

            };
        },

        components: {
            'date-picker': myDatepicker
        },

        methods: {
            prepareComponent() {
                var dateObj = new Date();
                var month = dateObj.getMonth() + 1; //months from 1-12
                var day = dateObj.getDate();
                var year = dateObj.getFullYear();

                this.date_start.time = year + "-" + month + "-" + day;
                this.date_end.time = year + "-" + month + "-" + day;
            },

            getResults: function() {
                this.$http.get('/work_sessions/summary?date_start=' + this.date_start.time + '&date_end=' + this.date_end.time + '&timeframe=')
                        .then(response => {
                            if ( response.body.length ) {
                                this.results = response.body;
                            } else {
                                this.results = false;
                            }
                        });
            }
        }
    }
</script>