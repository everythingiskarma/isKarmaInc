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
  <link rel="stylesheet" type="text/css" href="iskarma.com/ui/icomoon/style.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/ui/css/html5.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/ui/css/ui.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/ui/css/web.css" charset="utf-8">
  <!-- initialize the css for api - account -->
  <link rel="stylesheet" type="text/css" href="iskarma.com/ui/css/account.css" charset="utf-8">
  <!-- initialize the css for api - authenticator -->
  <link rel="stylesheet" type="text/css" href="iskarma.com/ui/css/authenticator.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/ui/css/animations.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/ui/css/article.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/ui/css/carousel.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/ui/css/header.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/ui/css/pages.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/ui/css/search.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/ui/css/sidebar.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/ui/css/toggles.css" charset="utf-8">
  <link rel="stylesheet" type="text/css" href="iskarma.com/ui/css/welcome.css" charset="utf-8">
  <link rel="icon" type="image/ico" href="iskarma.com/favicon.ico" charset="utf-8">
  <script src="iskarma.com/ui/js/jquery.js"></script>
  <script>
    $(document).ready(function() {
      $.getScript('iskarma.com/ui/js/ajax.js');
      // initialize the ajax controller for api - authenticator
      $.getScript('iskarma.com/ui/js/api-controller-authenticator.js');
      // initialize the ajax controller for api - profile
      $.getScript('iskarma.com/ui/js/api-controller-profile.js');

      $.getScript('iskarma.com/ui/js/api-controller-static-content.js');
      $.getScript('iskarma.com/ui/js/api-controller-static-search.js');

      $.getScript('iskarma.com/ui/js/ui.js');
      $.getScript('iskarma.com/ui/js/ui-click-handlers.js');
      $.getScript('iskarma.com/ui/js/ui-field-validation.js');
      $.getScript('iskarma.com/ui/js/ui-startup.js');

      $.getScript('iskarma.com/ui/js/onboarding.js');
      $.getScript('iskarma.com/ui/js/countries.js');
      $.getScript('iskarma.com/ui/js/site.js');
      $.getScript('iskarma.com/ui/js/telemetry.js');
      $.getScript('iskarma.com/ui/js/copy-element-content.js');
    });
  </script>
</head>

<body>
  <div id="toTop" class="icon-up"></div>
  <header>
    <?php require_once 'iskarma.com/sections/header/layout.php'; ?>
    <wrapper>
      <esc class="icon-close"></esc>
      <div id="processing">
        <!--
          <logo class="loading">account></one>
            <two class="dot no-dots"></two>
            <three class="dot no-dots"></three>
            <four class="dot no-dots"></four>
            <five></five>
            <six></six>
            <seven></seven>
            <eight></eight>
          </logo>
        -->
        <span class="icon-spinner"></span>
        <span class="icon-spinner1"></span>
      </div>
      <load></load>
    </wrapper>
  </header>
  <sidebar>
    <?php require_once 'iskarma.com/sections/header/views/sidebar.php'; ?>
  </sidebar>
  <main>
    <?php
    // require activities slider carousel
    require_once 'iskarma.com/sections/header/views/slides.php';
    // load dynamic content in this section using jquery/ajax
    require_once 'iskarma.com/content/about/home.php';
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