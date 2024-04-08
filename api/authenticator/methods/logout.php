<?php
// process account logout and destroy all session variables

trait Logout {

  // method to process logout
  public function logout() {

    if(isset($_SESSION['loggedin'])) {
      // unset all session variables.

      // Destroy the session
      unset($_SESSION['loggedIn']);
      session_destroy();


    } else {
      // user is already logged out.
    } // end if $_SESSION
  } // end method to logout user
} // end trait

?>
