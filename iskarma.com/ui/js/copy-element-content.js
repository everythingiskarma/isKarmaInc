  function copy() {
    // Get the HTML content of the container (adjust as needed)
    var container = $(this).next().html();
    // you can also modify this function to use on specific elements
    //var container = $('.container').html();

    // Create a temporary textarea element to copy the content
    var tempContainer = $("<textarea>");

    // Add container HTML content into the textarea
    tempContainer.val(container);

    // Append the temporary textarea to the body
    $('body').append(tempContainer);

    // Select the content inside the textarea
    tempContainer.select();

    // Copy the selected content to clipboard
    document.execCommand('copy');

    // Remove the temporary textarea
    tempContainer.remove();

    // Show an alert message (optional)
    alert('Code copied to clipboard!');
  }
  /*
  # Usage HTML
  - create an html button before the element you want enable copying
  - if you want to copy content of a <div> use it like so
  <a class="copyBtn">copy content from next element</a>
  <div>
  <h2>this is a heading</h2>
  <p>this is a paragraph</p>
  <button type="submit">form button</button>
  <input type="text">
  </div>

  # Activate using JS
  $(".copyBtn").click(copy);
  - this will copy all the html content inside the element next to .copyBtn which is '<div>' in this example
  */
