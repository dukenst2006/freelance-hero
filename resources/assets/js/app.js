
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
Vue.component('work-session-summary', require('./components/WorkSessionSummary.vue'));

const app = new Vue({
    el: '#app'
});

$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});
$(document).on('click', 'a.jquery-postback', function(e) {
    e.preventDefault();
    var confirm_message = "Are you sure you want to delete this session?";

    var $this = $(this);

    if ( confirm(confirm_message) ) {
        $.post({
            type: $this.data('method'),
            url: $this.attr('href')
        }).done(function (data) {
            console.log(data);
            location.reload();
        });
    }
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