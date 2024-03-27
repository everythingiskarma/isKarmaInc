// MAIN NAVIGATION FUNCTIONALITY
// show nav menu on hover
$("navbar li").on("mouseover", function(){
  // first remove active class from sibling tabs and assign it to current tab
  $(this).addClass("active").siblings().removeClass("active");
  // get id of current element
  var currentTab = $(this).attr("id");
  // add isActive class to corresponding tab content and remove from its siblings
  $('nav ul.'+currentTab).stop().slideDown().siblings().hide();
});

// hide navigation when mAndroid-WebView-App-Templateouse leaves
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

// MISC FUNCTIONALITIES
