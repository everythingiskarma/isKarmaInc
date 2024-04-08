<?php
trait Properties {

    // Common properties
    protected $domain;
    protected $action;

    // Login/Logout related properties
    protected $email;
    protected $uid;
    protected $ipLogin;
    protected $ipConfirm;
    //protected $logout;
    //protected $loggedin;

    // generate uid related properties
    protected $isUnique;

    // send OTP related properties
    protected $isValidEmail;
    protected $isRegistered;
    protected $hasGatepass;
    protected $newGatepass;
    protected $otp;
    protected $otpType;
    protected $otpId;
    protected $otpGenerated;
    protected $otpEmailSent;
    protected $otpSent;
    //protected $otp_resends;

    // Confirm OTP related properties
    //protected $otp_attempts;
    protected $gatekeeperRegistered;
    protected $loggedIn;
    protected $confirmOTP;
    protected $attempts;
    protected $newAttempts;
    protected $remAttempts;
    protected $otpConfirmed;

    // session related properties
    //protected $session; // gets the current session id
    //protected $ip; // gets users ip address
    //protected $agent; // gets users browser and os
    //protected $referer; // gets users browser and os
    //protected $time; // gets users request time
    //protected $host; // gets users request domain
    //protected $cookie; // gets users request domain

}
?>
