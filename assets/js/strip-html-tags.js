  // function to strip html tags
  function stripHtmlTags(html) {
    // replace any html tag with empty string.
    return html.replace(/<[^>]*>/g, ' ');
  }
