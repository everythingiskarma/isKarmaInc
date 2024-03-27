  // Function to toggle fullscreen mode
  function toggleFullScreen() {
    if (!document.fullscreenElement && !document.mozFullScreenElement &&
      !document.webkitFullscreenElement && !document.msFullscreenElement ) {
        var e=document.documentElement;
        (e.requestFullscreen)?e.requestFullscreen():(e.webkitRequestFullscreen)?e.webkitRequestFullscreen():(e.mozRequestFullScreen)?e.mozRequestFullScreen():(e.msRequestFullscreen)?e.msRequestFullscreen():null;
      } else {
        (document.exitFullscreen)?document.exitFullscreen():
        (document.mozCancelFullScreen)?document.mozCancelFullScreen():
        (document.webkitExitFullscreen)?document.webkitExitFullscreen():
        (document.msExitFullscreen)?document.msExitFullscreen():null;
      }
    }

    // Add event listener for fullscreen change event
    document.addEventListener('fullscreenchange', function() {toggleFsIcon();});
    document.addEventListener('mozfullscreenchange', function() {toggleFsIcon();});
    document.addEventListener('MSFullscreenChange', function() {toggleFsIcon();});
    document.addEventListener('mozfullscreenchange', function() {toggleFsIcon();});

    // place this html element anywhere in your site and style it
    // <toggle id="efs" class="icon-fs"></toggle>
    // enter exit full screen functionality
    // Add event listener to toggle fullscreen on icon click
    $(document).on("click", "#efs", function() {
      toggleFullScreen();
    });

    function toggleFsIcon() {
      $("#efs").toggleClass("icon-efs icon-fs");
    }

    document.addEventListener('keydown', function(event) {
      if (event.key === 'F11') {
        event.preventDefault(); // Prevent default browser behavior for F11 key
        $("#efs").trigger("click");
      }
    });
