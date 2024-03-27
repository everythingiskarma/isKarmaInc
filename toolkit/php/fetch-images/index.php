<style>
html {background: #111;color: #fff;}
ul {list-style: none;padding: 0}
h1 {text-align: center;color: #ffff00}
h2 {color: #005599;}
pre {text-align: left; display: inline-block; margin: 0 auto;}
</style>
<?php
// Define the image paths
$i = [
    'images/logo.png',
    'images/logo1.png',
];
// Define the base URL for getSiteImages.php
$baseUrl = "fetch-images.php?image=";
?>
<h1>Welcome to isKarma Inc</h1>
<center>
  <div>
    <ul>
      <li>
        <p>add paths to multiple images in an array ($i) like so: <br/>
          <pre>
            <code>
$i = [
'images/logo.png',
'images/logo1.png',
];
            </code>
          </pre>
          <br>
          $baseUrl = "fetch-images.php?image=";<br>
          <br>
          and use images in php tag like so<br>
          <br/><\img src="<\?php echo $baseUrl . urlencode($i[0]); ?>" alt="Image name or title">
        </p>
      </li>
      <br>
      <li>
        <h2>using $i[0]</h2>
        <img src="<?php echo $baseUrl . urlencode($i[0]); ?>" alt="Image one">
      </li>
      <br>
      <li>
        <h2>using $i[1]</h2>
        <img src="<?php echo $baseUrl . urlencode($i[1]); ?>" alt="Image two">
      </li>
    </ul>
  </div>
</center>
