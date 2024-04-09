// ## AJAX REQUESTS ## //
var apiAuthenticator = 'api/authenticator/handler.php'; 
// # SEND OTP
$(document).on("click", "#login", function (event) {
    $("#processing").fadeIn();
    var email = $("#email").val();
    var requestData = {
        api: 'authenticator', // indicates which database to use
        action: 'sendOTP', // indicates which api action to perform
        email: email, // indicates which user requested the action
        domain: domain // indicates which domain requested the action
    };
    // Sending an AJAX request to the server to authenticate the email
    processRequest(apiAuthenticator, requestData, successCallback, errorCallback);
});
// # RESEND OTP
$(document).on("click", "#resend", function (event) {
    $("#processing").fadeIn();
    var email = $("#confirm").attr("email");
    var requestData = {
        api: 'authenticator', // indicates which database to use
        action: 'resendOTP', // indicates which api action to perform
        email: email, // indicates which user requested the action
        domain: domain // indicates which domain requested the action
    };
    // Sending an AJAX request to the server to authenticate the email
    processRequest(apiAuthenticator, requestData, successCallback, errorCallback);

});
// # CONFIRM OTP
$(document).on("click", "#confirm", function () {
    $("#processing").fadeIn();
    $(this).slideUp();
    $("#validOTP").slideDown();
    var otp = $("#otp").val();
    var uid = $(this).attr("uid");
    var otpId = $(this).attr("otpid");
    var otpType = $(this).attr("otptype");
    var requestData = {
        api: 'authenticator',
        action: 'confirmOTP',
        otp: otp,
        uid: uid,
        otpId: otpId,
        otpType: otpType,
        domain: domain
    }
    // Sending an AJAX request to the server to confirm OTP
    processRequest(apiAuthenticator, requestData, successCallback, errorCallback);
});


// # CANCEL LOGIN # -----------------------------------------------------------
$(document).on("click", "#cancel", function () {
    $("#processing").fadeIn();
    $("load").load('/iskarma.com/sections/dashboard/views/login.php', function () {
        $("#processing").fadeOut();
    });
    $("#resendTimer").html('');
});
// # END CANCEL LOGIN # -----------------------------------------------------------

// ## RESEND OTP TIMER ## ----------------------------------------------------------------
var interval; // Declare the interval variable outside the function scope
function resendOTPTimer(time) {
    $("#resend").hide();
    // Clear any existing interval
    if (interval) {
        clearInterval(interval);
    }
    var countdown = time;
    interval = setInterval(function () {
        countdown--;
        if (countdown < 0) {
            clearInterval(interval);
            $("#resendTimer").hide();
            var resend = '<div class="bbx" id="resend" tabindex="0"><div class="icon-btn"><span class="icon-mail"></span><a class="clear">Resend</a></div></div>';
            $("#validOTP").append(resend);
            $("#resend").show();
        } else {
            $("#resendTimer").html("Didn't recieve the email? Resend OTP in " + countdown + " seconds").slideDown();
        }
    }, 1000);
}
// ## END RESEND OTP TIMER ## ----------------------------------------------------------------


// // ## OTP FIELD VALIDATION RULES ## // //

// # function to validate otp input
function validateOTP(data) {
    var re = /^\d{6}$/;
    return re.test(data);
}

// # validate otp based on validation rules
$(document).on("keyup", "#otp", function () {
    var message = $("messages");
    var otp = $("#otp").val();
    //alert(otp);
    if (validateOTP(otp)) {
        // Remove error message
        message.html('<i>&check; Yes! That appears to be a valid OTP!</i>');
        // add green border to indicate valid email id
        $(this).addClass("valid");
        // show send OTP button
        $("#confirm").slideDown();
        $("#validOTP").hide();
    } else {
        // If input is not valid, show error and hide continue button
        $(this).removeClass("valid");
        message.html('<blink>validating...</blink><i>example: 123456</i>');
        $("#confirm").hide();
        $("#validOTP").slideDown();
    }
});

// # on blur event handler for otp field
$(document).on("blur", "#otp", function (event) {
    var input = $(this).val();
    if (input === '') {
        $("messages").html('<i>Check your inbox & enter the OTP you just received!</i>');
        $("#confirm").fadeOut();
    }
});

$(document).on("input", "#otp", function (event) {
    var message = $("messages");
    var otp = $(this).val();
    otp = otp.replace(/\D/g, "");
    if (otp.length > 6) {
        otp = otp.slice(0, 6);
    }
    $(this).val(otp);
});


// // ## EMAIL FIELD VALIDATION RULES ## // //
// # restrict invalid input characters in email input
$(document).on("keydown", "#email, #otp", function (event) {
    var message = $("messages");
    if (event.key === ' ') {
        event.preventDefault();
        message.html('<i>Uh uh! No spaces allowed here!</i>');
    }
});
// # Function to validate email format
function validateEmail(email) {
    var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return re.test(email);
}

// # Event handler for input blur
$(document).on("blur", "#email", function (event) {
    var input = $(this).val();
    if (input === '') {
        $("messages").html('<blink>Please enter your email!</blink>');
        $("#login").fadeOut();
    }
});

// # Event handler for keyup (typing) in the email input
$(document).on("keyup", "#email", function (event) {
    var message = $("messages");
    var email = $("#email").val();
    if (email === '') {
        $("#login").fadeOut();
        message.html('<blink>waiting for input...</blink>');
        return;
    }
    // Check if input is valid
    if (validateEmail(email)) {
        // Remove error message
        message.html('<i>&check; Yes! That appears to be a valid email address!</i>');
        // add green border to indicate valid email id
        $(this).addClass("valid");
        // show send OTP button
        $("#login").fadeIn();
    } else {
        // If input is not valid, show error and hide continue button
        $(this).removeClass("valid");
        message.html('<blink>validating...</blink><i>example: support@iskarma.com</i>');
        $("#login").fadeOut();
    }
});

function loadOTP(obj) {
    var otpId = obj.otpId;
    var otpType = obj.otpType;
    var uid = obj.uid;
    var email = obj.email;
    $("load").load('/iskarma.com/sections/dashboard/views/otp.php', function () {
        $("#confirm").attr({
            "otptype": otpType,
            "otpid": otpId,
            "uid": uid,
            "email": email
        });
        $("#otp").focus();
    });
    resendOTPTimer(120);
}


