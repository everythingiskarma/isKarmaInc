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
