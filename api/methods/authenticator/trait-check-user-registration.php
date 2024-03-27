<?php
trait CheckUserRegistration {

    public function checkUserRegistration() {

        // prepare query to check user database to determine if the email is already registered
        $checkUserTable = "SELECT uid FROM user WHERE email = ?";
        $stmt = $this->connection->prepare($checkUserTable);
        // if mysql query fails creates error report and returns false
        if(!$stmt) { // failed to prepare statement
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > check user registration > prepare-query',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to prepare query while checking registration status!' . $this->connection->error . '</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            return false;
        }
        // continue to bind parameters
        $stmt->bind_param('s', $this->email);
        if(!$stmt) { // failed to bind parameters
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > check user registration > bind-parameters',
                'resutl' => false,
                'message' => '<e><b class="icon-error"></b>Failed to bind parameters while checking registration' . $stmt->error . '</e>',
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
                'action' => 'send-otp > check user registration > execute-statement',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to execute the query after binding parameters while checking registration status!</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            return false;
        }

        // continue to get results
        $result = $stmt->get_result();
        if(!$result) { // failed to fetch results
            // create error report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > check user registration > fetch-results',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>Failed to get the results from the query while checking registration status!</e>',
                'resolution' => 'reset-login-form'
            );
            // close statement
            $stmt->close();
            return false;
        }

        // check if result fetched any rows
        if($result->num_rows > 0) {
            // user is registered, continue to send otp
            $this->isRegistered = true;
            // continue to fetch row
            $row = $result->fetch_assoc();
            if(!$row) { // failed to fetch row
                // create error report
                $this->report[] = array(
                    'api' => 'Authenticator',
                    'action' => 'send-otp > check user registration > fetch-row',
                    'result' => false,
                    'message' => '<e><b class="icon-error"></b>Failed to fetch row while checking registration status</e>',
                    'resolution' => 'reset-login-form'
                );
                // close statement
                $stmt->close();
                return false;
            }
            // get the uid of the registered email
            $this->uid = $row['uid'];
            // close statement
            $stmt->close();
            // create success report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > check user registration',
                'result' => true,
                'message' => '<in><b class="icon-user-check"></b>It is already registered in our eco-system!</in>',
                'advice' => 'next > continue-to-generate-and-send-otp'
            );

            // return true;

        } else {
            // user is not registered create report
            $this->report[] = array(
                'api' => 'Authenticator',
                'action' => 'send-otp > check user registration',
                'result' => false,
                'message' => '<e><b class="icon-error"></b>It is not yet registered in our eco-system!</e>',
                'advice' => 'next > continue to check gatekeeper registration'
            );

        } // end if

    } // end method checkUserRegistration()

} // end trait CheckUserRegistration

?>
