<?php
    // Set custom name for the session cookie
    session_name('everythingIsKarma');
    // start session before processing the post request (via ajax or php form)
    session_start();
    // report all errors in case the script fails to execute at some point
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    if(!isset($_SESSION['loggedIn'])) {

        require_once 'account/login.php';

    } else {
?>
<div class="light">
    <h1>WELCOME ABOARD!</h1>

    <br>
<center>

    <h2></h2>
	<div class="ibx icon-user">
	    <input id="name" type="text" placeholder="Enter your full name here" autofocus autocomplete="off" >
        <label>name</label>
	</div>

    <br>
	<div class="ibx icon-phone">
	    <input id="phone" type="text" placeholder="Enter your phone number here" autofocus autocomplete="off" >
        <label>mobile</label>
	</div>
    <br>
    <div class="icon-btn" tabIndex="0">
        <span class="icon-right"></span>
        <a class="clear">Continue</a>
    </div>
</center>
</div>
<?php
        require_once 'account/dashboard.php';

    }

?>
