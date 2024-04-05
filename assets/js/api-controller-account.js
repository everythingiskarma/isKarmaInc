// 
var uid = $("#uid").val();
// click handler for logout button
$(document).on("click", "#logout", function () {
    $("#processing").fadeIn();
    var dom = domain;
    var requestData = { api: 'authenticator', action: 'logout', uid: uid, domain: dom }
    // Sending an AJAX request to the server to process and confirm logout
    processRequest('api/authenticator.php', requestData, successCallback, errorCallback);
});

function dashboard() {
    $("load").load('/iskarma.com/views/wrapper/account/dashboard.php');
}


function getDashboard() {
    $("#processing").fadeIn();
    var requestData = {
        api: 'account', // indicates which api / database to use
        action: 'dashboard', // indicates which api action to perform
        domain: domain // indicates which domain requested the action
    };
    // Sending an AJAX request to the server to authenticate the email
    processRequest('api/account.php', requestData, successCallback, errorCallback);
}
