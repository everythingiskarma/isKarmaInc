// ## SEND OTP ## ------------------------------------------------------------------
// Event handler for submit button click
$(document).on("click", "#login", function(event) {

    $("#processing").fadeIn();
    var message = $("#email").next();
    var email = $("#email").val();
    var requestData = {
        api: 'authenticator', // indicates which database to use
        action: 'sendOTP', // indicates which api action to perform
        email: email, // indicates which user requested the action
        domain: domain // indicates which domain requested the action
    };

    function successCallback(report) {
        $("#reports > *").addClass('pre');
        if (Array.isArray(report) && report.length > 0) {
            report.forEach((obj, index) => {
                if (obj.hasOwnProperty('authOTP')) {
                    var otpId = obj.otpId;
                    var otpType = obj.otpType;
                    var uid = obj.uid;
                    $("#authLogin").slideUp();
                    $("#authOTP").load('/iskarma.com/views/authenticator/authOTP.php', function() {
                        $(this).slideDown();
                        $("#confirm").attr({
                            "otptype": otpType,
                            "otpid": otpId,
                            "uid": uid
                        });
                    });
                    resendOTPTimer(90);
                }
                setTimeout(() => {
                    if (obj.hasOwnProperty('message')) {
                        if(!$(".notifications").hasClass("on")) {
                            $(".notifications").trigger("click");
                        }
                        var reports = $("#reports");
                        var msg = obj.message;
                        reports.append(msg);
                        var fixed = $("fixed.reports");
                        fixed.scrollTop(fixed.prop("scrollHeight"));
                }
                }, 500 * index);
            });
        } else {
            console.error("invalid response format: Missing report data!");
        }
        $("#processing").fadeOut();
    }

    function errorCallback(xhr, status, error) {
        var errorMessage = xhr.status + ': ' + xhr.statusText;
        $("#errors").append(errorMessage + '<br/>');
        //console.error('AJAX error:', error);
        //message.html('<i>' + errorMessage + '</i>');
        console.error(errorMessage);
    }

    // Sending an AJAX request to the server to authenticate the email
    processRequest('api/authenticator.php', requestData, successCallback, errorCallback);

});

// Function to validate email format
function validateEmail(email) {
    var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return re.test(email);
}

// Event handler for input blur
$(document).on("blur", "#email", function(event) {
    var input = $(this).val();
    if (input === '') {
        $("#email").next().html('Welcome to isKarma Inc');
        $("#login").fadeOut();
    }
});

// Event handler for keyup (typing) in the email input
$(document).on("keyup", "#email", function(event) {

    var message = $(this).next();
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


// ## END SEND OTP ## --------------------------------------------------------------



// ## RESEND OTP -------------------------------------------------------------------

$(document).on("click", "#resend", function() {

    $("#processing").fadeIn();
    //var message = $("#email").next();
    var email = $("#email").val();
    var requestData = {
        api: 'authenticator', // indicates which database to use
        action: 'resendOTP', // indicates which api action to perform
        email: email, // indicates which user requested the action
        domain: domain // indicates which domain requested the action
    };

    function successCallback(report) {
        $("#reports > *").addClass('pre');
        if(Array.isArray(report) && report.length > 0) {
            report.forEach((obj, index) => {
                if(obj.hasOwnProperty('authOTP')) {
                    var otpId = obj.otpId;
                    var otpType = obj.otpType;
                    var uid = obj.uid;
                    $("#authLogin").slideUp();
                    $("#authOTP").load('/iskarma.com/views/authenticator/authOTP.php', function() {
                        $(this).slideDown();
                        $("#confirm").attr({
                            "otptype": otpType,
                            "otpid": otpId,
                            "uid": uid
                        });
                    });
                    resendOTPTimer(120);
                    //return;
                }
                setTimeout(() => {
                    if (obj.hasOwnProperty('message')) {
                        if(!$(".notifications").hasClass("on")) {
                            $(".notifications").trigger("click");
                        }
                        var reports = $("#reports");
                        var msg = obj.message;
                        reports.append(msg);
                        var fixed = $("fixed.reports");
                        fixed.scrollTop(fixed.prop("scrollHeight"));
                    }
                }, 500 * index);
            });
        }  else {
            console.error("invalid response format: Missing report data!");
        }
        delay(function() {
            $("#processing").fadeOut();
        }, 500);
    }

    function errorCallback(xhr, status, error) {
        var errorMessage = xhr.status + ': ' + xhr.statusText;
        $("#errors").append(errorMessage + '<br/>');
        //console.error('AJAX error:', error);
        //message.html('<i>' + errorMessage + '</i>');
        console.error(errorMessage);
    }

    // Sending an AJAX request to the server to authenticate the email
    processRequest('api/authenticator.php', requestData, successCallback, errorCallback);

});

var interval; // Declare the interval variable outside the function scope

function resendOTPTimer(time) {
    $("#resend").hide();

    // Clear any existing interval
    if (interval) {
        clearInterval(interval);
    }
    var countdown = time;
    interval = setInterval(function() {
        countdown--;
        if (countdown < 0) {
            clearInterval(interval);
            $("#resendTimer").hide();
            $("#resend").show();
        } else {
            $("#resendTimer").html("Resend OTP in " + countdown + " seconds").slideDown();
        }
    }, 1000);
}

// ## RESEND OTP ## ----------------------------------------------------------------



// ## CONFIRM OTP ## ---------------------------------------------------------------

$(document).on("click", "#confirm", function() {
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

    function successCallback(report) {
        $("#reports > *").addClass('pre');
        $("#otp").val('');
        if(Array.isArray(report) && report.length > 0) {
            report.forEach((obj, index) => {
                if(obj.hasOwnProperty('loggedIn')) {
                    $("account").load('/iskarma.com/views/account/dashboard.php', function() {
                        //return;
                    });
                }
                if (obj.hasOwnProperty('resolution')) {
                    var res = obj.resolution;
                    if(res === 'reset-login-form') {
                        $("#authOTP").slideUp();
                        $("#authLogin").slideDown();
                    }
                    //return; // If you want to stop the loop after finding 'authOTP', you can use 'break;' instead of 'return;'
                }
                setTimeout(() => {
                    if (obj.hasOwnProperty('message')) {
                        if(!$(".notifications").hasClass("on")) {
                            $(".notifications").trigger("click");
                        }
                        var reports = $("#reports");
                        var msg = obj.message;
                        reports.append(msg);
                        var fixed = $("fixed.reports");
                        fixed.scrollTop(fixed.prop("scrollHeight"));
                    }
                }, 500 * index);
            });
        }  else {
            console.error("invalid response format: Missing report data!");
        }
        $("#processing").fadeOut();
    }

    function errorCallback(xhr, status, error) {
        var errorMessage = 'Error occurred while processing the request. Please try again later.';
        console.error('AJAX error:', error);
        console.log(report);
        message.html('<i>' + errorMessage + '</i>');
    }

    // Sending an AJAX request to the server to confirm OTP
    processRequest('api/authenticator.php', requestData, successCallback, errorCallback);

});

// function to validate otp input
function validateOTP(data) {
    var re = /^\d{6}$/;
    return re.test(data);
}

// event handler for confirmOTP
$(document).on("keyup", "#otp", function() {
    var message = $("#otp").next();
    var otp = $("#otp").val();
    //alert(otp);
    if(validateOTP(otp)) {
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
        message.html('<i><blink>validating...</blink><br/>example: 123456</i>');
        $("#confirm").hide();
        $("#validOTP").slideDown();
    }
});

$(document).on("blur", "#otp", function(event) {
    var input = $(this).val();
    if (input === '') {
        $("#otp").next().html('<i>Please check your email for the OTP (One Time Password) and enter it here!</i>');
        $("#confirm").fadeOut();
    }
});

$(document).on("input", "#otp", function(event) {
    var message = $("#otp").next();
    var otp = $(this).val();
    otp = otp.replace(/\D/g, "");
    if(otp.length>6) {
        otp = otp.slice(0, 6);
    }
    $(this).val(otp);
});

$(document).on("click", "#auth #cancel", function() {
    $("#authOTP").html('');
    $("#authLogin").fadeIn();
    $("#resendTimer").html('');
});
// ## END CONFIRM OTP ## -----------------------------------------------------------



// ## COMMON FUNCTIONS ## ----------------------------------------------------------

    // restrict invalid input characters in email input
    $(document).on("keydown", "#email, #otp", function(event) {
        var message = $(this).next();
        if(event.key === ' ') {
            message.html('<i>Uh uh! No spaces allowed here!</i>');
            event.preventDefault();
        }
    });

// ## END COMMON FUNCTIONS ## ------------------------------------------------------
