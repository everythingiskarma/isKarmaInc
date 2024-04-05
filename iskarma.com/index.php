<!Doctype html>
<?php
// get current light mode
//if (isset($_SESSION['mode'])) {$mode = $_SESSION['mode'];} else {$mode = "light";}
?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to isKarma</title>
  <link rel="stylesheet" type="text/css" href="assets/icomoon/style.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/css/html5.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/css/ui.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/web.css" charset="utf-8">
  <!-- initialize the css for api - account -->
  <link rel="stylesheet" type="text/css" href="iskarma.com/css/account.css" charset="utf-8">
  <!-- initialize the css for api - authenticator -->
  <link rel="stylesheet" type="text/css" href="iskarma.com/css/authenticator.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/css/animations.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/css/article.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/css/carousel.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/css/header.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/css/pages.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/css/search.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/css/sidebar.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/css/toggles.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/css/welcome.css" charset="utf-8">
  <link rel="icon" type="image/ico" href="iskarma.com/favicon.ico" charset="utf-8">
  <script src="assets/js/jquery.js"></script>
  <script>
    $(document).ready(function() {
      $.getScript('assets/js/ajax.js');
      // initialize the ajax controller for api - authenticator
      $.getScript('assets/js/api-controller-authenticator.js'); 
      $.getScript('assets/js/api-controller-account.js');
      $.getScript('assets/js/api-controller-static-content.js');
      $.getScript('assets/js/api-controller-static-search.js');
      $.getScript('assets/js/countries.js'); 
      $.getScript('assets/js/onboarding.js'); 
      $.getScript('assets/js/html5.js');
      $.getScript('assets/js/ui.js');
      $.getScript('assets/js/copy-element-content.js');
      $.getScript('assets/js/delay-timer.js');
      $.getScript('assets/js/telemetry.js');
      $.getScript('assets/js/hard-refresh.js');
      $.getScript('assets/js/load-responsive-css.js');
      $.getScript('assets/js/scroll-to-top.js');
      $.getScript('assets/js/strip-html-tags.js');
      $.getScript('assets/js/toggle-fullscreen.js');
      $.getScript('assets/js/toggles.js');
      $.getScript('assets/js/clock.js');
      $.getScript('iskarma.com/site.js');
    });
  </script>
</head>

<body>
  <div id="toTop" class="icon-up"></div>
  <header>
    <?php require_once 'iskarma.com/views/header/header.php'; ?>
    <wrapper>
      <esc class="icon-close"></esc>
      <div id="processing"><span class="icon-spinner"></span></div>
      <load></load>
    </wrapper>
  </header>
  <sidebar>
    <?php require_once 'iskarma.com/views/header/sidebar.php'; ?>
  </sidebar>
  <main>
    <?php
    // require activities slider carousel
    require_once 'iskarma.com/views/header/slides.php';
    // load dynamic content in this section using jquery/ajax
    require_once 'iskarma.com/content/internal/home.php';
    ?>
  </main>
  <footer>
    <center>
      <a href="https://www.iskarma.com">www.iskarma.com</a><br>
      <small>
        Copyright &copy; 2024, Is Karma Inc. <br>
        <div class="date-clock">
          <?php echo date('l, j F, Y | '); ?>
          <clock></clock>
        </div>
      </small>
    </center>
  </footer>
  <div class="reporting">
    <div class="reports">
      <in><b class="icon-home"></b><i>Welcome to isKarma</i></in>
    </div>
    <div class="reports-grid">
      <div class="ib icon-search"></div>
      <input placeholder="Filter Notifications">
      <div id="x-reporting" class="ib icon-close"></div>
      </h2>
    </div>
  </div>
</body>

</html>