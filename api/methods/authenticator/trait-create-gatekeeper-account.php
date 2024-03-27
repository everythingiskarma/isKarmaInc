<?php
require_once 'trait-generate-uid.php'; // provides the trait GenerateUID

trait CreateGatekeeperAccount {

    use GenerateUID; // this trait provides the method generateUID();

    public function createGatekeeperAccount() {

        // generate a uid
        $this->uid = $this->generateUID();

        // make entry in the gatekeeper table (email, uid, domain, verified - '0' = pending otp confirmation)
        // continue to prepare statement
        $stmt = $this->connection->prepare("INSERT INTO gatekeeper (uid, email, domain) VALUES (?, ?, ?)");
        if(!$stmt) { // failed to prepare statement
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > create-gatekeeper-account > prepare-query',
                'result' => false,
                'message' => '<e><b class="icon-error"></b> Failed to prepare query while creating gatekeeper account!' . $this->connection->error . '</e>',
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
                'action' => 'send-otp > create-gatekeeper-account > bind-parameters',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to bind parameters while creating gatekeeper entry' . $stmt->error . '</e>',
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
                'action' => 'send-otp > create-gatekeeper-account > execute-statement',
                'result' => false,
                'message' => '<e><b class="icon-error"></b> Failed to execute the query while creating gatekeeper account!' . $stmt->error . '</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            return false;
        }

        // gatekeeper account successfully created in the gatekeeper table
        // create success report
        $this->report[] = array(
            'api' => 'Authenticator',
            'action' => 'send-otp > create-gatekeeper-account',
            'result' => true,
            'message' => '<in><b class="icon-enter"></b>This email address has been issued a gatepass!</in>',
            'advice' => 'next > create-otp-entry'
        );
        // close statement
        $stmt->close();

        // gatekeeper entry successfully created, continue to create otp entry and send otp by email
        $this->newGatepass = true;

    } // end method createGatekeeperAccount();

} // end trait CreateGatekeeperAccount
?>
