<?php

trait LoginUser {

    public function loginUser() {
        // user successfully logged in. set session variables and show account dashboard
        // indicates the domain name where the user was logged in from
        $_SESSION['domain'] = $this->domain;
        // indicates that the user is logged in
        $_SESSION['loggedIn'] = true;
        // indicates that the uid of the user logged in
        $_SESSION['uid'] = $this->uid;

        // create success report
        $this->report[] = array(
            'api' => 'Authenticator',
            'action' => 'confirm-otp > login-user',
            'result' => true,
            'message' => '<s><b class="icon-square-check"></b>You are now logged into your account on '.$_SESSION['domain'].'</s>',
            'loggedIn' => true
        );

        $this->loggedIn = true;
        // create entry in sessions table using information from $_SERVER array.


    } // end method loginUser();

} // end trait LoginUser

?>
