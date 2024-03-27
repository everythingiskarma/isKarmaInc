<?php

trait GenerateOTP {

    public function generateOTP() {

        $att = 0;
        // create new otp entry
        $stmt = $this->connection->prepare("INSERT INTO otp (uid, otp, type, attempts) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE otp = VALUES(otp), type = VALUES(type), attempts = VALUES(attempts)");

        if(!$stmt) { // failed to prepare statement
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > create-otp-entry > prepare statement',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to prepare query while creating otp entry!</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            return false;
        }
        // continue to prepare statement
        $stmt->bind_param('siii', $this->uid, $this->otp, $this->otpType, $att);
        if(!$stmt) { // failediskarmac_udbhav to bind parameters
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > create-otp-entry > bind-parameters',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to bind parameters while making otp entry</e>',
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
                'action' => 'send-otp > create-otp-entry > execute-statement',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to execute the query after binding parameters while creating otp entry!</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            return false;
        }
        // otp entry successfully created in the otps table
        $this->otpId = $stmt->insert_id;

        // close statement
        $stmt->close();

        // create success report
        $this->report[] = array(
            'api' => 'Authenticator',
            'action' => 'send-otp > create-otp-entry',
            'result' => true,
            'message' => '<in><b class="icon-key"></b>A new OTP (One Time Password) has been generated!</in>',
            'advice' => 'next > send-otp-by-email'
        );

        $this->otpGenerated = true;

    } // end method generateOTP();

} // end trait GenerateOTP
 ?>
