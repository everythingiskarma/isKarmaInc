$(document).ready(function() {

  $(document).on("click", "#getJWT", function() {

    $.ajax({
      url: 'getJWT.php',
      method: 'GET',
      headers: {
        'Authorization' : 'Bearer ' + jwtToken
      },
      success:function(response) {
        // handle success
      },
      error:function(xhr, status, error) {
        // handle error
      }
    });
  });
});
