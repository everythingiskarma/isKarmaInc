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

    function successCallback(report) {
        $("#reports > *").addClass('pre');
        if (Array.isArray(report) && report.length > 0) {
            report.forEach((obj, index) => {
                if (obj.hasOwnProperty('loggedOut')) {
                    $("load").load('/iskarma.com/views/wrapper/account.php', function () {
                        //return;
                    });
                }
                setTimeout(() => {
                    if (obj.hasOwnProperty('message')) {
                        if (!$("#notifications").hasClass("on")) {
                            $("#notifications").trigger("click");
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
        var errorMessage = 'Error occurred while processing the request. Please try again later.';
        console.error('AJAX error:', error);
        console.log(report);
        //message.html('<i>' + errorMessage + '</i>');
    }

    // Sending an AJAX request to the server to confirm OTP
    processRequest('api/authenticator.php', requestData, successCallback, errorCallback);

});

function getDashboard() {
    $("#processing").fadeIn();
    var requestData = {
        api: 'account', // indicates which api / database to use
        action: 'dashboard', // indicates which api action to perform
        domain: domain // indicates which domain requested the action
    };

    function successCallback(report) {
        $("#reports > *").addClass('pre');
        if (Array.isArray(report) && report.length > 0) {
            report.forEach((obj, index) => {
                if (obj.hasOwnProperty('onBoard')) {
                    $("load").load('/iskarma.com/views/wrapper/account/onboarding.php', function () {
                        //alert('onboard');
                    });
                } else if (obj.hasOwnProperty('getDashboard')) {
                    $("load").load('/iskarma.com/views/wrapper/account/dashboard.php', function () {
                        //alert('Dashboard!'); 
                    });
                }
                setTimeout(() => {
                    if (obj.hasOwnProperty('message')) {
                        if (!$("#notifications").hasClass("on")) {
                            $("#notifications").trigger("click");
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
    processRequest('api/account.php', requestData, successCallback, errorCallback);

}