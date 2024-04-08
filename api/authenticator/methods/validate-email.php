<?php
// create interface
trait ValidateEmail {

    // method to validate, filter and sanitize email inputs from user
    public function validateEmail() {

        // remove leading or trailing white spaces
        $email = trim($this->email);

        // Filter the email address
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // Validate the filtered email address
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) { // it is a valid email address

            // create success report
            $this->report[] = array(
              'api' => 'Authenticator',
              'action' => 'send-otp > validate-email',
              'result' => true,
              'message' => '<in><b class="icon-at"></b><i>'.$this->email.'</i> was successfully validated!</in>',
              'advice' => 'next > continue to check user registration'
            );

            $this->isValidEmail = true;

            //return true;

        } else { // email address is not valid

            // create error report
            $this->report[] = array(
              'api' => 'Authenticator',
              'action' => 'send-otp > validate-email',
              'result' => false,
              'message' => '<e><b class="icon-error"></b>Email address failed the validation check! Please enter a valid email address</e>',
              'resolution' => 'return to user and request another email input'
            );

            // return false;

        } // end if filter_var

    } // end method validateEmail()

} // end trait

?>
