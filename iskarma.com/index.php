<!Doctype html>
<?php
// get current light mode
//if (isset($_SESSION['mode'])) {$mode = $_SESSION['mode'];} else {$mode = "light";}
// define site header path
define ('va', 'iskarma.com/views/account/');
define ('vc', 'iskarma.com/views/content/');
define ('vh', 'iskarma.com/views/header/');
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to isKarma</title>
    <link rel="stylesheet" type="text/css" href="assets/icomoon/style.css">
    <link rel="stylesheet" type="text/css" href="iskarma.com/web.css">
    <link rel="stylesheet" type="text/css" href="iskarma.com/css/accounts.css">
    <link rel="stylesheet" type="text/css" href="iskarma.com/css/animations.css">
    <link rel="stylesheet" type="text/css" href="iskarma.com/css/article.css">
    <link rel="stylesheet" type="text/css" href="iskarma.com/css/carousel.css">
    <link rel="stylesheet" type="text/css" href="iskarma.com/css/html5.css">
    <link rel="stylesheet" type="text/css" href="iskarma.com/css/navigation.css">
    <link rel="stylesheet" type="text/css" href="iskarma.com/css/pages.css">
    <link rel="stylesheet" type="text/css" href="iskarma.com/css/search.css">
    <link rel="stylesheet" type="text/css" href="iskarma.com/css/sidebar.css">
    <link rel="stylesheet" type="text/css" href="iskarma.com/css/toggles.css">
    <link rel="stylesheet" type="text/css" href="iskarma.com/css/welcome.css">
    <link rel="icon" type="image/ico" href="iskarma.com/favicon.ico">
    <script src="assets/js/jquery.js"></script>
    <script>
      $(document).ready(function() {
        $.getScript('assets/js/ajax.js');
        $.getScript('assets/js/ajax-authentication.js');
        $.getScript('assets/js/ajax-account.js');
        $.getScript('assets/js/ajax-request-content.js');
        $.getScript('assets/js/ajax-search-content.js');
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
      <article class="full-modal-wrapper"></article>
      <compose class="full-modal-wrapper"><?php require_once vc . 'compose.php';?></compose>
      <account class="full-modal-wrapper"><?php require_once va . 'dashboard.php';?></account>
      <search class="full-modal-wrapper"><?php require_once vh . 'search.php';?></search>
      <?php
        // require all toggles
        require_once vh . 'toggles.php';
        // requie main navigation topbar
        require_once vh . 'nav.php';
        // require sidebar
        require_once vh . 'sidebar.php';
        // require activities slider carousel
        require_once vh . 'slides.php'
      ?>
    </header>
    <main>
      <?php
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
    <common>
        <fixed class="reports">
            <center>Welcome to isKarma</center>
            <div id="reports"></div>
        </fixed>
        <div id="filterReports">
            <h2>
                <span class="icon-not-on"></span>
                Notifications
                <icon class="icon-close"></icon>
            </h2>
        </div>
        <div id="processing"><span class="icon-spinner"></span></div>
    </common>
  </body>
</html>
