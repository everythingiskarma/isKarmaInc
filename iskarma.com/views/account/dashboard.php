<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
// check if user is logged in
if(isset($_SESSION['loggedIn'])) {
    // connect to database
?>
<div class="light">
    <h1>Dashboard</h1>
    <content>
        <h2>SESSION</h2>
        <section>
            <div class="grid37">
                <a>Your UID</a>
                <about>
                    <?php echo $_SESSION['uid']; ?>
                </about>
            </div>
            <div class="grid37">
                <a>Logout</a>
                <about>
                    <div id="logout" class="icon-btn" uid="<?php echo $_SESSION['uid']; ?>">
                        <span class="icon-exit"></span><a class="clear">Logout</a>
                    </div>
                </about>
            </div>
        </section>
    </content>
</div>

<?php

} else {
    // show login / register page
    ?>
    <div id="account">
        <br/>
        <a class="icon-iskarma" href="#welcome" location="iskarma.com/content/articles" title="Welcome to isKarma Inc">
            <span class="path1"></span>
            <span class="path2"></span>
            <span class="path3"></span>
            <span class="path4"></span>
        </a>
    </div>
    <br/>
    <div id="authLogin">
        <div class="center">Sign in or Register</div>
        <div id="auth" class="icon-mail">
            <input type="email" id="email" placeholder="Please enter your email address" autofocus autocomplete="off" value="udbhav@iskarma.com">
            <div id="message">Welcome to isKarma Inc</div>
            <div id="login" class="button" tabindex="0">Send OTP</div>
        </div>
    </div>
    <div id="authOTP">
    </div>
    <?php
}

?>
