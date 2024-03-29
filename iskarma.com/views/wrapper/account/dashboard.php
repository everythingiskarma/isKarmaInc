<?php
if(session_status() === PHP_SESSION_NONE) {
    // Set custom name for the session cookie
    session_name('everythingIsKarma');
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
    <?php
}

?>
