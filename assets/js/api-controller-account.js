// 
var uid = $("#uid").val();

// click handler for logout button
$(document).on("click", "#logout", function () {
    $("#processing").fadeIn();
    var uid = $("#logout").attr("uid");
    var dom = domain;
    var requestData = { api: 'authenticator', action: 'logout', uid: uid, domain: dom }
    // Sending an AJAX request to the server to process and confirm logout
    processRequest('api/authenticator.php', requestData, successCallback, errorCallback);
});

// click handler for onboarding continue button
$(document).on("click", "#step1", function () {
    // validate inputs
    var fn = btoa($("#firstname").val());
    var ln = btoa($("#lastname").val());
    var cc = btoa($("#country").attr("countrycode"));
    var cn = btoa($("#country").attr("countryname"));
    var dc = btoa($("#country").attr("dialcode"));
    var mo = btoa($("#mobile").val());
    if (fn.length === 0) {
        alert('First name cannot be empty');
        $("#firstname").focus();
        return;
    }
    if (ln.length === 0) {
        alert('Last name cannot be empty');
        $("#lastname").focus();
        return;
    }
    if (cc.length === 0 || cn.length === 0 || dc.length === 0) {
        alert('Please select your country and dial code');
        $("#country").trigger("click");
        return;
    }
    if (mo.length === 0) {
        alert('Phone number cannot be empty');
        $("#mobile").focus();
        return;
    }
    // If all conditions are met, proceed with further logic here
    $("#processing").fadeIn();
    var requestData = { api: 'account', action: 'step1', uid: uid, fn: fn, ln: ln, cc: cc, cn: cn, dc: dc, mo: mo }
    // send an ajax request to ther server to process and confirm step 1 of onboarding
    processRequest('api/account.php', requestData, successCallback, errorCallback);
});


function onBoarding(obj) {
    var step = obj.step;
    $("load").load('/iskarma.com/views/wrapper/account/onboarding.php', function () {
        $(".tab." + step).addClass("active");
        $("input").focus();
    });
}

function dashboard() {
    $("load").load('/iskarma.com/views/wrapper/account/dashboard.php');
}

function loadAccount() {
    $("load").load('/iskarma.com/views/wrapper/account.php');
    $("togglebar").load('/iskarma.com/views/header/togglebar.php');
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