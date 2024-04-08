<?php

trait RegisterGatekeeperAccount
{

    // create verified user account
    private function registerGatekeeperAccount()
    {

        // get email from gatekeeper table
        $stmt = $this->connection->prepare("SELECT * FROM gatekeeper WHERE uid = ?");
        if (!$stmt) { // failed to prepare statement
            // create error report
            $this->report[] = array(
                'message' => '<e><b class="icon-error"></b>Failed to prepare query while getting email from gatekeeper account!' . $this->connection->error . '</e>',
                'resolution' => 'reset-login-form'
            );
        }
        $stmt->bind_param("s", $this->uid);
        if (!$stmt) { // failed to bind parameters
            // create error report
            $this->report[] = array(
                'message' => '<e><b class="icon-error"></b>Failed to bind parameters while getting email from gatekeeper account!' . $stmt->error . '</e>',
                'resolution' => 'reset-login-form'
            );
        }
        $stmt->execute();
        if (!$stmt) { // failed to execute statement
            // create error report
            $this->report[] = array(
                'message' => '<e><b class="icon-error"></b>Failed to execute statement while getting email from gatekeeper account!' . $stmt->error . '</e>',
                'resolution' => 'reset-login-form'
            );
        }
        $result = $stmt->get_result();
        if (!$result) { // failed to get result
            // create error report
            $this->report[] = array(
                'message' => '<e><b class="icon-error"></b>Failed to get result while getting email from gatekeeper account!' . $result->error . '</e>',
                'resolution' => 'reset-login-form'
            );
        }
        if ($result->num_rows > 0) {
            // get row
            $row = $result->fetch_assoc();
            $this->email = $row['email'];
        } else {
            // unable to get email from gatekeeper table
        }
        $result->close();
        $stmt->close();

        // register user / verify gatepass 
        // prepare statement
        $stmt = $this->connection->prepare("INSERT INTO user (uid, email, domain) values (?, ?, ?)");
        if (!$stmt) { // failed to prepare statement
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
        if (!$stmt) { // failed to bind parameters
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
        if (!$stmt) { // unable to execute mysql statement
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

        // create uid entry in other tables
        try {
            $p = 1;
            $s1 = $this->connection->prepare("INSERT INTO `address` (`uid`, `priority`) values (?, ?)");
            $s1->bind_param('si', $this->uid, $p);
            $s1->execute();

            $s2 = $this->connection->prepare("INSERT INTO `communication` (uid) values (?)");
            $s2->bind_param('s', $this->uid);
            $s2->execute();

            $s3 = $this->connection->prepare("INSERT INTO `kyc` (uid) values (?)");
            $s3->bind_param('s', $this->uid);
            $s3->execute();

            $s4 = $this->connection->prepare("INSERT INTO `kyc_business` (uid) values (?)");
            $s4->bind_param('s', $this->uid);
            $s4->execute();

            $s5 = $this->connection->prepare("INSERT INTO `preferences` (uid) values (?)");
            $s5->bind_param('s', $this->uid);
            $s5->execute();

            $s6 = $this->connection->prepare("INSERT INTO `security` (uid) values (?)");
            $s6->bind_param('s', $this->uid);
            $s6->execute();

            $this->connection->commit();

        } catch (Exception $e) {

            $this->connection->rollback();
            // create error report
            $this->report[] = array(
                'message' => '<e><b class="icon-error"></b>' . $e->getMessage() . '</e>'
            );
            
        }


        $type = 1;
        $status = 1;

        // gatekeeper account successfully registered, update otp status and type and continue to login user
        $stmt = $this->connection->prepare("UPDATE otp SET type = ?, status = ? WHERE uid = ?");
        if (!$stmt) { // failed to prepare statement
            // create error report
            $this->report[] = array(
                'message' => '<e><b class="icon-error"></b>Failed to prepare query while updating otp status!' . $this->connection->error . '</e>',
                'resolution' => 'reset-login-form'
            );
        }
        $stmt->bind_param('iis', $type, $status, $this->uid);
        if (!$stmt) { // failed to bind parameters
            // create error report
            $this->report[] = array(
                'message' => '<e><b class="icon-error"></b>Failed to bind parameters while updating otp status!' . $stmt->error . '</e>',
                'resolution' => 'reset-login-form'
            );
        }
        $stmt->execute();
        if (!$stmt) { // failed to execute statement
            // create error report
            $this->report[] = array(
                'message' => '<e><b class="icon-error"></b>Failed to execute statement while updating otp status!' . $stmt->error . '</e>',
                'resolution' => 'reset-login-form'
            );
        }

        $stmt->close();
        // create success report
        $this->report[] = array(
            'message' => '<s><b class="icon-done"></b>updated otp status!</s>',
            'resolution' => 'next -> login'
        );

        // create entries in wallet database
        $this->database = 'iskarmac_wallet';
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        try {
            //code...
            $status = 1;
            $stmt = $this->connection->prepare("INSERT INTO `wallet_balance` (uid, status) VALUES (?, ?)");
            $stmt->bind_param('si', $this->uid, $status);
            $stmt->execute();

        } catch (Exception $e) {
            $this->report[] = array(
                'message' => '<e><b class="icon-error"></b>Error :' . $e->getMessage() . '</e>'
            );
        }

        $this->gatekeeperRegistered = true;
    } // end method registerGatekeeperAccount();

} // end trait RegisterGatekeeperAccount
