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

    h1.textContent = ("0" + hours).slice(-2) + ":" + ("0" + minutes).slice(-2) + ":" + ("0" + seconds).slice(-2);

    timer();
}

function timer() {
    t = setTimeout(add, 1000);
}
timer();