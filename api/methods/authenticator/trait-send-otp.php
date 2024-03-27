<?php
require_once 'trait-validate-email.php'; // provides trait ValidateEmail
require_once 'trait-check-user-registration.php'; // provides trait CheckUserRegistration
require_once 'trait-check-gatekeeper-registration.php'; // provides trait CheckGatekeeperRegistration
require_once 'trait-create-gatekeeper-account.php'; // provides trait CreateGatekeeperAccount
require_once 'trait-generate-otp.php'; // provides trait GenerateOTP
require_once 'trait-send-otp-by-email.php'; // provides trait SendOTPByEmail

trait SendOTP {

    use ValidateEmail; // this trait provides method validateEmail();
    use CheckUserRegistration; // this trait provides method checkUserRegistration();
    use CheckGatekeeperRegistration; // this trait provides method checkGatekeeperRegistration();
    use CreateGatekeeperAccount; // this trait provides method createGatekeeperAccount();
    use GenerateOTP; // this trait provides the method generateOTP();
    use SendOTPByEmail; // this trait provides the method sendOTPByEmail();

    public function sendOTP() {

        $this->isValidEmail = false;
        $this->isRegistered = false;
        $this->hasGatepass = false;
        $this->newGatepass = false;
        $this->otpGenerated = false;
        $this->otpEmailSent = false;
        $this->otpSent = false;

        // validate the incoming email id
        $this->validateEmail();
        if($this->isValidEmail === false) {
            // failed to validate email address
            // stop further processing of the script
            return false;
        }

        // continue to check user registration
        $this->checkUserRegistration();
        if($this->isRegistered === true) {
            // continue to send otp
            $this->otpType = 1;
            $this->emailOTP();
            return true;
        }

        // continue to check gatekeeper registration
        $this->checkGatekeeperRegistration();
        if($this->hasGatepass === true) {
            // continue to send otp
            $this->otpType = 0;
            $this->emailOTP();
            return true;
        }

        // continue to create gatekeeper account
        $this->createGatekeeperAccount();
        if($this->newGatepass === true) {
            // continue to send otp
            $this->otpType = 0;
            $this->emailOTP();
            return true;
        }

    } // end method processEmail();

    // method to make new OTP entry
    private function emailOTP() {

        // generate a 6 digit otp
        $this->otp = mt_rand(100000, 999999);

        // execute method generateOTP();
        $this->generateOTP();
        if($this->otpGenerated === false) {
            // failed to create entry in otp table
            // stop further processing of the script
            return false;
        }

        // execute method sendOTPByEmail
        $this->sendOTPByEmail();
        if($this->otpEmailSent === false) {
            // failed to email otp
            // stop further processing of the script
            return false;
        }

        $this->otpSent = true;

    } //  end method sendOTP();

} // end trait SendOTP
?>
