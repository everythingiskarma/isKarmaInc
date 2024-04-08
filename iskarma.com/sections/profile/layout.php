<?php
// Set custom name for the session cookie
session_name('everythingIsKarma');
// start session before processing the post request (via ajax or php form)
session_start();
// report all errors in case the script fails to execute at some point
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (!isset($_SESSION['loggedIn'])) {
    require_once 'views/login.php';
} else {
?>
    <script>
        $(document).ready(function() {
            getDashboard();
        });
    </script>
<?php
}
?>