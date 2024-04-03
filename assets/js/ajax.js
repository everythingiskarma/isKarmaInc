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

function successCallback(report) {
  $("#reports > *").addClass('pre');
  if (Array.isArray(report) && report.length > 0) {
    report.forEach((obj, index) => {
      switch (true) {
        case obj.hasOwnProperty('loggedOut'):
        case obj.hasOwnProperty('loggedIn'):
          loadAccount();
          break;
        case obj.hasOwnProperty('onBoard'):
          loadOnboarding(obj);
          break;
        case obj.hasOwnProperty('getDashboard'):
          loadDashboard();
          break;
        case obj.hasOwnProperty('authOTP'):
          loadOTP(obj);
          break;
      }

      setTimeout(() => {
        if (obj.hasOwnProperty('message')) {
          if (!$("#notifications").hasClass("on")) {
            $("#notifications").trigger("click");
          }
          var reports = $(".reports");
          var msg = obj.message;
          reports.append(msg);
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
