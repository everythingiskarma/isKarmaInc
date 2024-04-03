$(document).on("click", "#logout", function () {
    $("#processing").fadeIn();
    var uid = $("#logout").attr("uid");
    var dom = domain;
    var requestData = {
        api: 'authenticator',
        action: 'logout',
        uid: uid,
        domain: dom
    }
    // Sending an AJAX request to the server to confirm OTP
    processRequest('api/authenticator.php', requestData, successCallback, errorCallback);
});


function loadOnboarding(obj) {
    var step = obj.step;
    $("load").load('/iskarma.com/views/wrapper/account/onboarding.php', function () {
        $(".tab." + step).addClass("active");
        $("input").focus();
    });
}

function loadDashboard() {
    $("load").load('/iskarma.com/views/wrapper/account/dashboard.php');
}

function loadAccount() {
    
    $("load").load('/iskarma.com/views/wrapper/account.php');
    $("#togglebar").load('/iskarma.com/views/header/togglebar.php');
}

function loadOTP(obj) {
    var otpId = obj.otpId;
    var otpType = obj.otpType;
    var uid = obj.uid;
    $("load").load('/iskarma.com/views/wrapper/account/otp.php', function () {
        $("#confirm").attr({
            "otptype": otpType,
            "otpid": otpId,
            "uid": uid
        });
        $("#otp").focus();
    });
    resendOTPTimer(90);
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