  // on pressing ctrl+shift+z hard refresh the page bypassing the cache
  $(document).keydown(function(e) {
    // Check if Ctrl + Shift + Z is pressed
    if (e.ctrlKey && e.shiftKey && e.key === 'Z') {
      // Refresh the page
      location.reload(true);
    }
  });
