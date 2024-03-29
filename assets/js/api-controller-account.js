$(document).on("click", "#logout a", function() {

    $("#processing").fadeIn();
    var uid = $("#logout").attr("uid");
    var dom = domain;
    var requestData = {
        api : 'authenticator',
        action : 'logout',
        uid : uid,
        domain: dom
    }

    function successCallback(report) {
        $("#reports > *").addClass('pre');
        if(Array.isArray(report) && report.length > 0) {
            report.forEach((obj, index) => {
                if(obj.hasOwnProperty('loggedOut')) {
                    $("load").load('/iskarma.com/views/wrapper/account/login.php', function() {
                        //return;
                    });
                }
                setTimeout(() => {
                    if (obj.hasOwnProperty('message')) {
                        if(!$("#notifications").hasClass("on")) {
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
        }  else {
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
