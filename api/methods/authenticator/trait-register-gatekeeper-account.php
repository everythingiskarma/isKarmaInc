<?php

trait RegisterGatekeeperAccount {

    // create verified user account
    private function registerGatekeeperAccount() {

        // get email from gatekeeper table
        $stmt = $this->connection->prepare("SELECT * FROM gatekeeper WHERE uid = ?");
        $stmt->bind_param("s", $this->uid);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            // get row
            $row = $result->fetch_assoc();
            $this->email = $row['email'];
        } else {
            // unable to get email from gatekeeper table
        }
        $result->close();
        $stmt->close();
        // prepare statement
        $stmt = $this->connection->prepare("INSERT INTO user (uid, email, domain) values (?, ?, ?)");
        if(!$stmt) { // failed to prepare statement
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > register-gatekeeper-account > prepare-query',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to prepare query while registering gatekeeper account!' . $this->connection->error . '</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            return false;
        }

        // continue to bind parameters
        $stmt->bind_param('sss', $this->uid, $this->email, $this->domain);
        if(!$stmt) { // failed to bind parameters
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > register-gatekeeper-account > bind-parameters',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to bind parameters while registering gatekeeper account' . $stmt->error . '</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            return false;
        }

        // continue to execute statement
        $stmt->execute();
        if(!$stmt) { // unable to execute mysql statement
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > register-gatekeeper-account > execute statement',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to execute the query while registering gatekeeper account!' . $stmt->error . '</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            return false;
        }
        // gatekeeper account successfully registered in the user table
        // create success report
        $this->report[] = array(
            'api' => 'Authenticator',
            'action' => 'send-otp > register-gatekeeper-account',
            'result' => true,
            'message' => '<s><b class="icon-done-all"></b>Successfully registered gatekeeper account!</s>',
            'advice' => 'next > continue-to-create-otp-entry'
        );
        // close statement
        $stmt->close();

        // gatekeeper account successfully registered, continue to login user
        $this->gatekeeperRegistered = true;

    } // end method registerGatekeeperAccount();

} // end trait RegisterGatekeeperAccount

?>
