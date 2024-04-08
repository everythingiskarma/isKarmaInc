
// SIDEBAR
// AJAX CONTENT REQUEST FUNCTIONALITY using (api/staticPhpContent.php)
// start ajax sidebar content request
$(document).on("click", "sidebar li", function() {
  // prepare request post data
  var requestData = {
    requestContentLocation: 'iskarma.com/content/internal',
    requestContentName: $(this).attr("id"),
    requestDomain: domain
  };

  function successCallback(report) {
    // check if the report contains the api, action, result, message, content
    if(Array.isArray(report) && report.length > 0) {
      // destructure the array and assign keys as variables
      var { api, action, result, message, content } = report[0];

      $("article").html(content).animate({scrollTop: 0}, 400);
      $("#reports").append(message);

    } else {
      console.error("Invalid response format: Missing report data!");
    }
    console.log(report);
  }

  function errorCallback(xhr, status, error) {
    var errorMessage = 'Error occurred while processing the request. Please try again later.';
    console.error('AJAX error:', error);
    $("article").html('close this modal');
    $("#message").html('<div class="error">' + errorMessage + '</div>');
  }

  // send request to get content
  processRequest('api/static/content.php', requestData, successCallback, errorCallback); // end request to get content
  // close the sidebar on click
  $("#sidebarToggle").trigger("click");
  // show article full modal wrapper and toggle button to return
  $("article, #articleToggle").fadeIn();
});
// end ajax sidebar content request
