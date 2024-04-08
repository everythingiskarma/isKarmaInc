<?php
// Set custom name for the session cookie
session_name('everythingIsKarma');
// start session before processing the post request (via ajax or php form)
session_start();
// report all errors in case the script fails to execute at some point
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
/////////////////////////////////////////////////////////////////////////////////////////
// initiate a database connection
require_once "../../api-helpers/connect.php";
// declare class properties used across the api
require_once "methods/properties.php"; // provides trait Properties
/////////////////////////////////////////////////////////////////////////////////////////
//require_once "methods/authenticator/trait-session.php"; // provides trait Sessions
//-------------------------------------------------------------------------------------//
/////////////////////////////////////////////////////////////////////////////////////////
require_once "methods/send-otp.php"; // provides trait SendOTP
require_once "methods/confirm-otp.php"; // provides trait ConfirmOTP
/////////////////////////////////////////////////////////////////////////////////////////
require_once "methods/logout.php"; // provides trait Logout

class Authenticator extends Connect {

    //use Sessions; // provides method session()
    use Properties; // provides class properties
    use SendOTP; // provides method sendOTP()
    use ConfirmOTP; // provides method confirmOTP()
    use Logout; // provides method logout()

    // constructor
    public function __construct() {
        parent::__construct(); // call the constructor of the parent class conDb;
        $this->authenticate();

        if(isset($_SESSION['loggedIn'])) {
            $this->report[] = array(
                'login' => $_SESSION['loggedIn'],
                'uid' => $_SESSION['uid'],
                'domain' => $_SESSION['domain']
            );
        }
    } // end function __construct

    // method to process post request DataPlease check your email for the OTP (One Time Password) and enter it here!
    private function authenticate() {
        // Assign class property values request based on parameters sent
        $this->domain = $_POST['domain']; // source domain

        // check if action post variable is sent
        if(isset($_POST['action'])) {

            $this->action = $_POST['action'];

            switch ($this->action) {

                case 'sendOTP':
                    // set post variable as class property
                    $this->email = $_POST['email'];
                    $this->domain = $_POST['domain'];
                    // execute method sendOTP and create success/error report based on the result
                    $this->sendOTP();
                    if($this->otpSent === false) {
                        // failed to send otp
                        // create error report
                        $this->report[] = array(
                            'api' => 'Authenticator',
                            'action' => 'send-otp',
                            'result' => false,
                            'message' => '<e><b class="icon-error"></b>Error: Unable to send OTP. Please try again after some time.</e>',
                            'resolution' => 'reset-login-form'
                        );
                        return false;
                    } else {
                        // otp sent successfully
                        // create success report
                        $this->report[] = array(
                            'api' => 'Authenticator',
                            'action' => 'send-otp',
                            'result' => true,
                            'message' => '<s><b class="icon-done-all"></b>Please check your inbox for the OTP we just sent you. In case it ends up in your spam/junk folder, you should mark it as not spam to recieve it in your inbox the next time!</s>',
                            'authOTP' => true,
                            'otpId' => $this->otpId,
                            'otpType' => $this->otpType,
                            'uid' => $this->uid,
                            'email' => $this->email
                        );
                        return true;
                    }
                    // code...
                break;

                case 'resendOTP':
                    // set post variable as class property
                    $this->email = $_POST['email'];
                    // include trait SendOTP
                    // execute method sendOTP and create success/error report based on the result
                    $this->sendOTP();

                    if($this->otpSent === false) {
                        // failed to send otp
                        // create error report
                        $this->report[] = array(
                            'api' => 'Authenticator',
                            'action' => 'resend-opt',
                            'result' => false,
                            'message' => '<e><b class="icon-error"></b>Error: Unable to resend OTP. Please try again after some time.</e>',
                            'resolution' => 'reset-login-form'
                        );
                        return false;
                    } else {
                        // otp sent successfully
                        // create success report
                        $this->report[] = array(
                            'api' => 'Authenticator',
                            'action' => 'resend-otp',
                            'result' => true,
                            'message' => '<s><b class="icon-done-all"></b>OTP successfully RESENT. Please check your email inbox. In case it ended up in your spam/junk folder, you should mark it as not spam to recieve it in your inbox the next time!
                            </s>',
                            'authOTP' => true,
                            'otpId' => $this->otpId,
                            'otpType' => $this->otpType,
                            'uid' => $this->uid,
                            'email' => $this->email
                        );
                        return true;
                    }
                    // code...
                break;

                case 'confirmOTP':
                    // get the uid, otpType, otpId and otp from post data
                    $this->otp = $_POST['otp'];
                    $this->uid = $_POST['uid'];
                    $this->otpId = $_POST['otpId'];
                    $this->otpType = $_POST['otpType'];
                    // execute method confirmOTP and create error response if result is false
                    $this->confirmOTP();

                    if($this->otpConfirmed === false) { // failed to confirm OTP
                        // create error report
                        if($this->remAttempts < 1) {
                            $this->report[] = array(
                                'api' => 'Authenticator',
                                'action' => 'confirm-otp',
                                'result' => false,
                                'message' => '<e><b class="icon-error"></b>Unable to verify OTP. Please confirm your email address and request a new OTP.</e>',
                                'resolution' => '???? suggest user to re-enter the correct otp'
                            );
                        }
                        return false;
                    } else { // otp confirmation successfull, check if user is logged in

                        // create success report
                        $this->report[] = array(
                            'api' => 'Authenticator',
                            'action' => 'confirm-otp',
                            'result' => true,
                            //'message' => '<s><b class="icon-done-all"></b>OTP has been successfully confirmed. You are now logged in</s>',
                            'advice' => 'show-account-dashboard'
                        );
                        return true;
                    }
                    // code...
                break;

                case 'logout':
                    // execute method logout() and create error response if result is false
                    unset($_SESSION['loggedIn']);
                    session_destroy();

                    if(isset($_SESSION['loggedIn'])) { // failed to logout user
                        // create error report
                        $this->report[] = array(
                            'api' => 'Authenticator',
                            'action' => 'logout',
                            'result' => false,
                            'message' => '<e><b class="icon-error"></b>Unable to logout. Please try again after some time.</e>',
                            'content' => '??'
                        );
                        return false;
                    } else {
                        // create success report
                        $this->report[] = array(
                            'api' => 'Authenticator',
                            'action' => 'logout',
                            'loggedOut' => true,
                            'message' => '<e><b class="icon-exit"></b>You have been successfully logged out!</e>',
                            'advice' => 'reload account section'
                        );
                        return true;
                    }

                break;

                default:
                    // code...
                    break;
            }
        } else {
            // no action directive recieved
        }

    } // end method authenticate

    // method to access success array
    public function getReport() {
        return json_encode($this->report);
    }

} // end class Authenticator

// instantiate the class Authenticator
$authenticator = new Authenticator();

// output report arrays as json
echo $authenticator->getReport();

?>
