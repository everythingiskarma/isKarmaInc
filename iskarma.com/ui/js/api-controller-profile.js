// this must be placed right after login is confirmed
var uid = $("#uid").val();
// click handler for logout button
$(document).on("click", "#logout", function () {
    $("#processing").fadeIn();
    var dom = domain;
    var requestData = {
        api: 'authenticator',
        action: 'logout',
        uid: uid,
        domain: domain
    }
    // Sending an AJAX request to the server to process and confirm logout
    processRequest(apiAuthenticator, requestData, successCallback, errorCallback);
});

function dashboard() {
    $("load").load('/iskarma.com/sections/profile/views/dashboard.php');
}

function getDashboard() {
    var requestData = {
        api: 'profile', // indicates which api / database to use
        action: 'dashboard', // indicates which api action to perform
        domain: domain // indicates which domain requested the action
    };
    // Sending an AJAX request to the server to authenticate the email
    processRequest(apiProfile, requestData, successCallback, errorCallback);
}

