$(document).ready(function() {

  // get current domain
  // var domain = window.location.hostname;
  var domain = "www.iskarma.com";
  domain = domain.replace(/^www\./, '');

  // Function to make AJAX requests
  function requestContent(url, requestData, successCallback, errorCallback) {
    $.ajax({
      url: url,
      type: 'POST',
      data: requestData, // Corrected variable name
      dataType: 'json',
      success: function(response) {
        if (response.error) {
          errorCallback(response.message);
        } else {
          successCallback(response.content);
        }
      },
      error: function(xhr, status, error) {
        var errorMessage = 'Error occurred while processing the request. Please try again later.';
        errorCallback(errorMessage);
        console.error('AJAX error:', error);
      }
    });
  }

  // load sidebar content dynamically
  $(document).on("click", "sidebar li a", function() {
    // prepare request data
    var requestData = {
      requestContentType: 'articles',
      requestContent: $(this).attr("id"),
      requestFrom: domain
    };

    // send request to get content
    requestContent('services/getSiteContent.php', requestData,
    function(content) {
      $("main article").html(content);
    },
    function(errorMessage) {
      $("main article").html('<div class="error">' + errorMessage + '</div>');
    }
  );
  // end ajax content request

  // close the sidebar on click
  $("#sidebarToggle").trigger("click");
  // toggle article modal box
  $("article, #articleToggle").fadeIn();

  // close article and reopen sidebar
  $("#articleToggle").on("click", function() {
    $(this).fadeOut();
    $("article").fadeOut();
    $("#sidebarToggle").trigger("click");
  });

  // search functionality
  $("search input").on("focus blur", function() {
    $("#searchInput").toggleClass("icon-navigation-more icon-search");
  });

  // close modal on pressing escape
  $(document).keyup(function(e) {
    // check if pressed key is esc
    if(e.keyCode === 27) {
      $(".icon-arrow-left").trigger("click");
    }
  });

  // scroll to top of the page
  // Show or hide the scroll-to-top button based on scroll position
  $(window).on("scroll", function() {
    if ($(this).scrollTop() > 100) { // Adjust the scroll distance as needed
      $('#toTop').fadeIn();
    } else {
      $('#toTop').fadeOut();
    }
  });

  $("article").on("scroll",function() {
    if ($(this).scrollTop() > 100) { // Adjust the scroll distance as needed
      $('#toTop').fadeIn();
      $("#floatNav").addClass("floatNav");
    } else {
      $('#toTop').fadeOut();
      $("#floatNav").removeClass("floatNav");
    }
  });

  // Scroll to top when the button is clicked
  $('#toTop').on("click", function() {
    $('html, body, .full-modal-wrapper').animate({
      scrollTop: 0
    }, 400); // Adjust the animation speed as needed
  });

  // toggle search
  $("#searchToggle").on("click", function() {
    // close all open toggles
    $("#sidebarToggle.icon-close").trigger("click");
    // toggle searchToggle button icon class
    $(this).toggleClass("icon-search icon-close");
    // toggle search modal box
    $("search").slideToggle();
  });

  // toggle sidebar
  $("#sidebarToggle").on("click", function() {
      // toggle sidebarToggle button icon class
      $(this).toggleClass("icon-list icon-close");
      // toggle sidebar
      $("sidebar").stop().animate({width:'toggle', height:'toggle'}, 100);
  });
  // show the welcome slide on page load
  $(".slideWelcome").slideDown();

  // show nav menu on hover
  $("navbar li").on("mouseover", function(){
    // first remove active class from sibling tabs and assign it to current tab
    $(this).addClass("active").siblings().removeClass("active");
    // get id of current element
    var currentTab = $(this).attr("id");
    // add isActive class to corresponding tab content and remove from its siblings
    $('nav ul.'+currentTab).stop().slideDown().siblings().hide();
  });

  // hide navigation when mouse leaves
  $("nav ul").on("mouseleave", function() {
    $("navbar li").removeClass("active");
    $("nav ul").slideUp("slow");
  });

  // show slide on hover the nav
  $("nav li").on("mouseover", function() {
    var currentSlide = $(this).attr("id");
    $("carousel ul li").stop().hide();
    $('carousel ul li.'+currentSlide).stop().fadeIn();
    //alert("currentSlide");
  });

});
