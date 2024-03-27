// Function to delay execution
var delayTimer;
function delay(callback, ms) {
    clearTimeout(delayTimer);
    delayTimer = setTimeout(callback, ms);
}

/*
// USAGE

$(document).on("click", "#element", function() {

    delay(function() {
        execute some code after 2 seconds!!
    }, 2000);

});

*/
