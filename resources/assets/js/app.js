
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('alert', require('./components/Alert.vue'));

const app = new Vue({
    el: '#app',
    mounted: function() {
    	console.log('Vue ready.')
    }
});

// code originally from main.js
$(document).ready(function() {
  //   $(".datepicker").datepicker({
		// dateFormat: "yy-mm-dd"
  //   });

    $("#custom-timeframe-button").on("click", function() {
        $(this).closest(".row").hide();
        $("#custom-timeframe-selectors").show();
    });

    $("#preset-timeframe-button").on("click", function() {
        $(this).closest(".row").hide();
        $("#date_start").val('');
        $("#date_end").val('');
        $("#preset-timeframe-selectors").show();
    });

    $("#sessions-report").on("submit", function(e) {
        e.preventDefault();
        $("#result-container").html('');
        var timeframe = $("#timeframe").val();
        var date_start = $("#date_start").val();
        var date_end = $("#date_end").val();
        $.ajax({
            url: "/work_sessions/summary",
            method: "GET",
            data: { 
                timeframe : timeframe,
                date_start: date_start,
                date_end: date_end
            }
        }).done(function(data) {
            if ( data.length ) {
                for ( var i = 0; i < data.length; i++ ) {
                    $("#result-container").append("<p>" + data[i].name + ": " + data[i].total_time + " hr(s)</p>");
                }
            } else {
                $("#result-container").html("<p>No completed work sessions.</p>");
            }
        });
    });
});


/*
 * Work Session Clock variables and functions.
 *
 */
var h1 = document.getElementById("counter");
var currentTime = document.getElementById("counter").textContent;
var timeSegments = currentTime.split(":");
var seconds = timeSegments[2];
var minutes = timeSegments[1];
var hours = timeSegments[0];
var t;

function add() {
    seconds++;
    if (seconds >= 60) {
        seconds = 0;
        minutes++;
        if (minutes >= 60) {
            minutes = 0;
            hours++;
        }
    }

    h1.textContent = ("0" + hours).slice(-2) + ":" + ("0" + minutes).slice(-2) + ":" + ("0" + seconds).slice(-2);

    timer();
}

function timer() {
    t = setTimeout(add, 1000);
}
timer();