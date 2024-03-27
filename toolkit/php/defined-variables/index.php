<?php
  // define string value
  $domain = preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']);
  define('domain', $domain);
  // define file location
  define('style', 'resources/style.css');

?>
<link rel="stylesheet" type="text/css" href="<?php echo style; ?>">

<!--
# Usage HTML
  - use the defined variables in html using php tags like so
-->
<pre>
  <code>
    <?php echo $domain; ?>
  </code>
</pre>
