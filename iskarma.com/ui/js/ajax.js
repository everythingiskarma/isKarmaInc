/// Shared function to process AJAX requests
function processRequest(
  url, // url of the requested api file
  requestData, // an array of request variables sent to the api
  successCallback, // function to handle success (must be specified inside the click event handler)
  errorCallback // function to handle error (also to be specified inside the click event handler)
) {
  $.ajax({
    url: url, // api url that will receive post request
    type: 'POST', // method of request
    data: requestData, // array of request data
    dataType: 'json', // expecting a json response from the api
    success: successCallback, // to be defined in the click event handler
    error: errorCallback // to be defined in the click event handler
  });
}
// performs respective functions after recieving response to the ajax request from php
function successCallback(report) {
  $(".reports > *").addClass('pre');
  // every api request sends a report that contains specific object property indicating futher actions that need to be performed after successful response. based on which object property is sent, specific jquery functions load respective views and perform other post load actions.
  var ncount = 0;
  if (Array.isArray(report) && report.length > 0) {
    report.forEach((obj, index) => {
      switch (true) {
        case obj.hasOwnProperty('loggedOut'): // indicates logout was successful, shows login page
        case obj.hasOwnProperty('loggedIn'): // indicates login was successful, loads profile overview
          // reloads togglebar and loads login or profile overview. Follows (ajax.js)
          loadAccount(obj);
          break;
        case obj.hasOwnProperty('onBoarding'): // indicates onboarding is pending
          // loads onboarding view and respective step based on object property step. Follows (onboarding.js)
          onBoarding(obj);
          break;
        case obj.hasOwnProperty('profile'): // indicates onboarding is complete shows profile overview
          // loads profile wrapper. Follows (api-controller-profile.js)
          profileOverview(obj);
          break;
        case obj.hasOwnProperty('authOTP'): // indicates otp has been sent shows confirm otp interface
        // loads confirm otp wrapper. Follows (api-controller-authenticator.js)
          loadOTP(obj);
          break;
      }
      // displays system messages in the report box
      setTimeout(() => {
        if (obj.hasOwnProperty('message')) {
          if (!$("#notifications").hasClass("on")) {
            $("#notifications").trigger("click");
          }
          var reports = $(".reports");
          var msg = obj.message;
          reports.append(msg);
          ncount++;
          $(".ncount").text(ncount).show();
          var scroll = $(".reports");
          scroll.scrollTop(scroll.prop("scrollHeight"));
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
}

function loadAccount() {
  $("load").load('/iskarma.com/sections/profile/layout.php'); // reloads load html after login/logout
  $("togglebar").load('/iskarma.com/sections/header/views/togglebar.php'); // reloads togglebar after login/logout
}