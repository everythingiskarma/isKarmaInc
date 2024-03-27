<?php

trait UpdateOTPAttempts {

    public function updateOTPAttempts() {

        $this->newAttempts = $this->attempts + 1;
        $this->remAttempts = 4 - $this->newAttempts;

        // prepare query statement
        $stmt = $this->connection->prepare("UPDATE otp SET attempts = ? WHERE id = ?");
        if(!$stmt) { // failed to prepare statement
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'confirm-otp > update-otp-attempts > prepare-query',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to prepare query while updating otp attempts!</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            // prevent further processing of the script
            return false;
        }

        // continue to bind parameters
        $stmt->bind_param('ii', $this->newAttempts, $this->otpId);
        if(!$stmt) { // failed to bind parameters
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'confirm-otp > update-otp-attempts > bind-parameters',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to bind parameters while updating otp attempts</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            // prevent further processing of the script
            return false;
        }

        // continue to execute query
        $stmt->execute();
        if(!$stmt) { // failed to execute statement
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'confirm-otp > update-otp-attempts > execute-statement',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to execute the query while updating otp attempts!</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            // prevent further processing of the script
            return false;
        }

        // create success report
        $this->report[] = array(
            'api' => 'Authenticator',
            'action' => 'update-attempts-confirm-otp',
            'result' => true,
            'message' => '<o><b class="icon-square-edit"></b>Failed attempt has been recorded! You have "'.$this->remAttempts.'" attempts remaining before you will need to request a new OTP!</o>',
            'advice' => 're-enter correct otp'
        );

        // close statement
        $stmt->close();
        // prevent further processing of the script
        return true;

    } // end method updateOTPAttempts();

} // end trait UpdateOTPAttempts

?>
