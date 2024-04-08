<?php

trait SendOTPByEmailFallback {

    public function sendOTPByEmailFallback() {

        // set smtp configuration
        ini_set("sendmail_path", "sendmail -t -i -f authenticator@iskarma.com -S mail.iskarma.com -au authenticator@iskarma.com -ap xcZw0po7flL2");

        if(mail($to, $subject, $message, $headers)) {
            // email successfully sent via smtp fallback method
            // Email handed off to the mail server, but delivery success not guaranteed
            // create success report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > otp-by-email-fallback',
                'result' => true,
                'message' => '<s><b class="icon-done-all"></b> Your OTP has been Successfully sent using SMTP fallback method</s>',
                'advice' => 'next > populate-confirm-otp-input-field'
            );

            $this->otpEmailSent = true;

        } else {
            // failed to send email via fallback method
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > send-otp-by-email-fallback',
                'result' => false,
                'message' => '<e><b class="icon-error"></b> We were unable to send OTP via SMTP fallback email functionality as well.</e>',
                'resolution' => 'reset-login-form'
            );

        } // end if / else

    } // end method sendOTPByEmailFallback();

} // end trait SendOTPByEmailFallback

?>
