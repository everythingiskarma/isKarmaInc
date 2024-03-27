<!Doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to isKarma</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="../../assets/js/jquery.js"></script>
    <link rel="icon" type="image/ico" href="../../iskarma.com/favicon.ico">

    <script>
      $(document).ready(function() {
        $(document).on("keyup", "#filter", function() {
          var text = $(this).val().toLowerCase();
          $("ul li").each(function() {
            var xt = $(this).find("span").text().toLowerCase();
            if(xt.includes(text)) {
              $(this).fadeIn();
            } else {
              $(this).fadeOut();
            }
          });
        });
      });
    </script>

    <style>
      html {background: #000; color:#fff; list-style: none}
      html *, html *::before {outline: none; transition: all 0.2s ease-in}
      ul {list-style: none; padding: 0}
      li {display: inline-block; margin: 10px; text-align: center; width: 100px; }
      li div::before {display: block; font-size: 50px; line-height: 80px; padding: 10px; }
      li:hover div::before {font-size: 60px}
      li *, li *::before {color: #333  !important}
      li:hover *, li:hover *::before {color: #ffff00 !important}
      li span {font-size: 15px;line-height: 30px;display: block; background: #070707}
      input {display: block; width: 300px; border: 2px solid #002500; background: none; border-radius: 30px; padding: 10px; font-size: 20px; line-height: 40px; color: #777; margin: 50px auto; text-align: center; }
      input:focus, input:active, input:focus-visible {border-color: #ffff00; width: 350px}
    </style>
  </head>
  <body>
    <input type="text" placeholder="filter icon by name" id="filter">
    <?php
    // Read the CSS file
    $cssFile = file_get_contents('style.css');

    // Regular expression to match class names and their associated content values
    preg_match_all('/\.([a-zA-Z0-9_-]+):before\s*{\s*content:\s*"([^"]*)";/s', $cssFile, $matches);

    // Check if matches were found
    if (!empty($matches[1]) && !empty($matches[2])) {
        // Output the matches as list items
        echo '<ul>';
        foreach ($matches[1] as $index => $className) {
            echo '<li>';
            echo '<div class="' . htmlspecialchars($className) . '"></div>';
            //echo '<span>' . htmlspecialchars($className) . '</span>';
            $iconName = substr($className, 5);
            echo '<span>' . htmlspecialchars($iconName) . '</span>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo 'No matches found in CSS file.';
    }
    ?>
  </body>
</html>
