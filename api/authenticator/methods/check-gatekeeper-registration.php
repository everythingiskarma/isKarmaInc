<?php
trait CheckGatekeeperRegistration {

    public function checkGatekeeperRegistration() {

        $this->hasGatepass = false;

        // account is not yet registered, continue to check if there is an entry in the gatekeeper table
        // prepare query --------------
        $stmt = $this->connection->prepare("SELECT uid FROM gatekeeper WHERE email = ?");
        if(!$stmt) { // failed to prepare statement
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > check-gatekeeper-registration > prepare-query',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to prepare query while checking gatekeeper registration' . $this->connection->error . '</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            return false;
        }
        // bind parameters --------------
        $stmt->bind_param("s", $this->email);
        if(!$stmt) { // failed to bind parameters
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > check-gatekeeper-registration > bind-parameters',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to bind parameters while checking gatekeeper registration' . $stmt->error . '</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            return false;
        }
        // execute query --------------
        $stmt->execute();
        if(!$stmt) { // failed to execute statement
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > check-gatekeeper-registration > execute-statement',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to execute query while checking gatekeeper registration!' . $stmt->error . '</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            return false;
        }
        // get results --------------
        $result = $stmt->get_result();
        if(!$result) { // failed to fetch results
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > check-gatekeeper-registration > get-query-result',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to get query result while checking gatekeeper registration!' . $result->error . '</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            return false;
        }

        // check if there is a match in the table --------------
        if($result->num_rows > 0) { // if user is in gatekeeper table
            // user has gatepass, continue to send otp
            $this->hasGatepass = true;
            // create info report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > check-gatekeeper-registration > check-gatepass',
                'result' => true,
                'message' => '<in><b class="icon-enter"></b>We have already issued a gatepass for this email address!</in>',
                'advice' => 'next > continue-to-create-otp-entry'
            );
            // continue to fetch row
            $row = $result->fetch_assoc();
            if(!$row) { // failed to fetch row
                // create error report
                $this->report[] = array(
                    'api' => 'Authenticator',
                    'action' => 'send-otp > check-gatekeeper-registration > fetch-row',
                    'result' => false,
                    'message' => '<e><b class="icon-error"></b>Failed to fetch row while checking gatekeeper registration</e>',
                    'advice' => 'reset-login-form'
                );
                // close statement
                $stmt->close();
                return false;
            }
            // get the uid of the gatepass
            $this->uid = $row['uid'];
            // close statement
            $stmt->close();

            // return true;

        } else { // user does not have a gatepass
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > check-gatekeeper-registration',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>This email address does not have a gatepass yet!</e>',
                'resolution' => 'next > continue to create gatekeeper'
            );

        } // end if / else

    } // end method checkGatekeeperRegistration();

} // end trait CheckGatekeeperRegistration

?>
