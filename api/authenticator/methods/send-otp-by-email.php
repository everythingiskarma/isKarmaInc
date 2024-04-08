<?php

require_once 'send-otp-by-email-fallback.php'; // provides trait SendOTPByEmailFallback

trait SendOTPByEmail {

    use SendOTPByEmailFallback; // provides method sendOTPByEmailFallback();

    // method to send OTP via email (you need to implement this function)
    public function sendOTPByEmail() {

        // send otp by email
        $to = $this->email;
        $subject = "Your One-Time Password (OTP)";
        $message = "Your OTP is: $this->otp";
        $headers = "From: authenticator@iskarma.com";
//        $headers .= "Reply-To: support+authenticator@iskarma.com\r\n";
//        $headers .= "X-Mailer: PHP/" . phpversion();

        // send mail
        if(mail($to, $subject, $message, $headers)) {
            // email successfully sent via native mail() method
            // Email handed off to the mail server, but delivery success not guaranteed
            // create success report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > otp-by-email-native',
                'result' => true,
                'message' => '<s><b class="icon-done-all"></b>Your OTP has been successfully dispatched via primary email service!</s>',
                'advice' => 'next > populate-confirm-otp-input-field'
            );

            $this->otpEmailSent = true;

        } else {
            // failed to send email via native mail() method
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > send-otp-by-email-native',
                'result' => false,
                'message' => '<e><b class="icon-error"></b> We were unable to send OTP via native email functionality.</e>',
                'resolution' => 'reset-login-form'
            );

            // try to again send via smtp alternative method
                $this->sendOTPByEmailFallback();

        } // end if / else

    } // end method sendOTPByEmail

} // end trait SendOTPByEmail

?>
