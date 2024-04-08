<?php

require_once 'register-gatekeeper-account.php'; // provides trait RegisterGatekeeperAccount
require_once 'login-user.php'; // provides trait LoginUser
require_once 'update-otp-attempts.php'; // provides trait UpdateOTPAttempts

trait ConfirmOTP {

    use RegisterGatekeeperAccount; // provides method registerGatekeeperAccount();
    use LoginUser; // provides method loginUser();
    use UpdateOTPAttempts; // provides method updateOTPAttempts();


    public function confirmOTP() {

        $this->otpConfirmed = false;
        $this->loggedIn = false;
        $this->gatekeeperRegistered = false;

        // check the otp table for an entry that matches the 'uid' and the 'otp'
        $stmt = $this->connection->prepare("SELECT * FROM otp WHERE id=? AND uid=? AND type=?");
        if(!$stmt) { // failed to prepare statement
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'confirm-otp > check-otp-entry > prepare-query',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to prepare query while checking otp entry!</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            return false;
        }

        // continue to prepare statement
        $stmt->bind_param('isi', $this->otpId, $this->uid, $this->otpType);
        if(!$stmt) { // failed to bind parameters
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'confirm-otp > check-otp-entry > bind-parameters',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to bind parameters while checking otp entry</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            return false;
        }

        // continue to execute statement
        $stmt->execute();
        if(!$stmt) { // failed to execute statement
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'confirm-otp > check-otp-entry > execute-statement',
                'result' => false,
                'message' => '<e><b class="icon-error"></b> Failed to execute the query after binding parameters while checking otp entry!</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            return false;
        }

        // continue to get the result set
        $result = $stmt->get_result();
        if(!$result) { // failed to get result
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'confirm-otp > check-otp-entry > get-result',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to get result while checking otp entry!</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            return false;
        }

        // continue to fetch the first row from the result set
        $row = $result->fetch_assoc();
        if(!$row) { // failed to fetch rows
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'confirm-otp > check-otp-entry > fetch-rows',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to fetch rows while checking otp entry!</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            return false;
        }

        // continue to count rows
        if($row !== null) { // a row was fetched successfully
            // otp entry exists, continue to check if otp is correct
            if($this->otp == $row['otp']) {
                // otp matches.
                $this->otpConfirmed = true;

                // check otp type and continue to login user
                if($row['type'] === 0) { // is a gatekeeper account

                    // continue to register gatekeeper account and login user
                    $this->registerGatekeeperAccount();

                    // check if gatekeeper registration was successful
                    if($this->gatekeeperRegistered === false) { // failed to register gatekeeper account
                        // create error report
                        $this->report[] = array(
                            'api' => 'Authenticator',
                            'action' => 'confirm-otp > check-otp-entry > register-gatekeeper-account',
                            'result' => false,
                            'message' => '<e><b class="icon-error"></b>Failed to register gatekeeper account. Please try again after some time</e>',
                            'resolution' => 'reset-login-form'
                        );
                        $this->otpConfirmed = false;
                        // prevent further processing of the script
                        return false;
                    }

                }

                if($this->otpConfirmed === true) {

                    // continue to login user
                    $this->loginUser();

                    // check if user login was successful
                    if($this->loggedIn === true) {
                        // user logged in successfully
                        $this->otpConfirmed = true;
                        // close statement
                        $stmt->close();
                        // prevent further processing of the script
                        return true;

                    } else {
                        // user login failed
                        // create error report
                        $this->report[] = array(
                            'api' => 'Authenticator',
                            'action' => 'confirm-otp > check-otp-entry > login-user',
                            'result' => false,
                            'message' => '<e><b class="icon-error"></b>Unable to login User. Please re-enter your email address and request another otp.</e>',
                            'resolution' => 'reset-login-form'
                        );
                        // close statement
                        $stmt->close();
                        // prevent further processing of the script
                        return false;
                    }

                }

            } else {
                // get current attemts count from query result
                $this->attempts = $row['attempts'];
                // otp does not match.
                if($this->attempts > 3) {
                }
                // close previous query statement
                //$stmt->close();
                // check attempt count
                if($this->attempts < 3) {
                    // create error report
                    $this->report[] = array(
                        'api' => 'Authenticator',
                        'action' => 'confirm-otp',
                        'result' => false,
                        'message' => '<e><b class="icon-error"></b>Incorrect OTP entered. Please check the OTP sent to your email address and enter the correct OTP</e>',
                        'resolution' => 'renter-correct-otp'
                    );
                    // update attempt count by +1 return to user and ask to re-enter correct otp
                    // update the attempts count in the database entry
                    $this->updateOTPAttempts();

                } else {
                    // exceeded maximum allowed attempts for the last otp sent. request a new otp
                    // create error report
                    $this->report[] = array(
                        'api' => 'Authenticator',
                        'action' => 'confirm-otp',
                        'result' => false,
                        'message' => '<e><b class="icon-error"></b>OTP Expired. You have exceeded maximum allowed attempts to enter the correct OTP. Please request another otp and try signing in again!</e>',
                        'resolution' => 'reset-login-form'
                    );
                    // close statement
                    $stmt->close();
                    // prevent further processing of the script
                    return false;
                }

            }

        } else {
            // no rows matched 'confirmOTP' post request data. prompt user to request another otp
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'confirm-otp > check-otp-entry',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Unable to find an otp entry matching the post request parameters. Please re-enter your email address and request another otp</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            // prevent further processing of the script
            return false;

        }


        // if there is a match
        // 1. get the otp type from the type field.
        // 1a. if type is 0,
        // generate a new encryption key (gatepass).
        // create an entry in the users table with the email 'id', 'uid' and the 'gatepass'.
        // destroy any current session variables and set new session $_SESSION['loggedin']
        // 1b. if type is 1,
        // destroy any current session variables and set new session $_SESSION['loggedin']

    } // end method confirmOTP();

} // end trait ConfirmOTP

?>
