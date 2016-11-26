<template>
	<div>
	    <div class="row">
	        <div class="form-group col-sm-3">
	            <label for="date_start">Timeframe</label>
	            <input v-on:keyup="getResults" v-model="date_start" class="form-control" name="date_start" type="text" placeholder="Start Date">
	        </div>
	        <div class="form-group col-sm-3">
	            <label for="date_end">&nbsp;</label>
	            <input v-on:keyup="getResults" v-model="date_end" class="form-control" name="date_end" type="text" placeholder="End Date">
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
    export default {
    	mounted: function() {
            this.getResults();
    	},

    	data: function() {
    		return {
    			date_start: '2016-01-01',
    			date_end: '2016-10-02',
    			results: false
    		};
    	},

        methods: {
        	getResults: function() {
                this.$http.get('/work_sessions/summary?date_start=' + this.date_start + '&date_end=' + this.date_end + '&timeframe=')
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