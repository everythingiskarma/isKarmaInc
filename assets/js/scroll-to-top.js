  // scroll to top of the page
  // Show or hide the scroll-to-top button based on scroll position
  $(window).on("scroll", function() {
    if ($(this).scrollTop() > 100) { // Adjust the scroll distance as needed
      $('#toTop').fadeIn();
    } else {
      $('#toTop').fadeOut();
    }
  });

  // SCROLL HTML, FULL MODAL WRAPPERS AND OTHER OVERLAYS
  $(".full-modal-wrapper, #searchResultDetails, #searchResults").on("scroll",function() {
    if ($(this).scrollTop() > 400) { // Adjust the scroll distance as needed
      $('#toTop').fadeIn();
      $("#floatNav").addClass("floatNav");
    } else {
      $('#toTop').stop().fadeOut();
      $("#floatNav").removeClass("floatNav");
    }
  });

  $("search").on("scroll",function() {
    if ($(this).scrollTop() > 100) { // Adjust the scroll distance as needed
      $(this).addClass("sticky");
    } else {
      $(this).removeClass("sticky");
    }
  });

  // Scroll to top when the button is clicked
  $('#toTop').on("click", function() {
    $('html, body, .full-modal-wrapper, #searchResultDetails, #searchResults').animate({
      scrollTop: 0
    }, 400); // Adjust the animation speed as needed
  });
