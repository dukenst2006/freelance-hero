$(document).ready(function() {
    $(".datepicker").datepicker({
		dateFormat: "yy-mm-dd"
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

    h1.textContent = hours + ":" + minutes + ":" + seconds;

    timer();
}

function timer() {
    t = setTimeout(add, 1000);
}
timer();