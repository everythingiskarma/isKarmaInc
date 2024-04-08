<?php
trait GenerateUID {
  // method to generate a unique ID and verify its uniqueness by matching in the `gatekeeper` and `users` table
  public function generateUID() {

    do { // starts a do/while loop till a unique id is achieved after checking user and gaterkeepr tables

          // Generate a unique id
          $length = 16;
          $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_=+';
          $uid = "";
          for ($i = 0; $i < $length; $i++) {
            $uid .= $characters[rand(0, strlen($characters) - 1)];
          }

          // Check database for uniqueness
          $checkUID = "SELECT COUNT(*) AS total FROM (
            SELECT uid FROM user WHERE uid = ?
            UNION ALL
            SELECT uid FROM gatekeeper WHERE uid = ?
          ) combined_tables";

          // Prepare mysql query statement
          $stmt = $this->connection->prepare($checkUID);
          if(!$stmt) { // if prepare query fails, creates error report and closes mysql connection
            // failed to prepare mysql statement while checking uid uniqueness
            // close mysql connection
            $stmt->close();
            // create error report
            $this->report[] = array(
              'api' => 'Authenticator',
              'action' => 'send-otp > create-gatekeeper-account > generate-uid > prepare-query',
              'result' => false,
              'message' => '<e><b class="icon-error"></b> Unable to prepare mysql query while generating uid!</e>',
              'resolution' => 'reset-login-form'
            );
            return false;
          }

          // if query is successful, continues to bind parameters
          $stmt->bind_param("ss", $uid, $uid);
          if(!$stmt) { // if binding parameters fails, closes mysql connection and creates error report
            // failed to bind parameters
            // close mysql connection
            $stmt->close();
            // create error report
            $this->report[] = array(
              'api' => 'Authenticator',
              'action' => 'send-otp > create-gatekeeper-account > generate-uid > bind-parameters',
              'result' => false,
              'message' => '<e><b class="icon-error"></b> Unable to bind parameters while generating uid</e>',
              'resolution' => 'reset-login-form'
            );
            return false;
          }

          // execute prepared and binded mysql query statement
          $stmt->execute();
          if(!$stmt) { // if mysql statement fails to execute, closes mysql connection and creates error report
            // failed to execute query while checking uid uniqueness
            // close mysql connection
            $stmt->close();
            // create error report
            $this->report[] = array(
              'api' => 'Authenticator',
              'action' => 'send-otp > create-gatekeeper-account > generate-uid > execute-query',
              'result' => false,
              'message' => '<e><b class="icon-error"></b> Unable to execute prepared mysql query while generating uid!</e>',
              'resolution' => 'reset-login-form'
            );
            return false;
          }

          // get results from mysql query
          $result = $stmt->get_result();
          if(!$result) { // if mysql fails to get results closes mysql connection and creates error report
            // failed to fetch result from the query
            // close mysql connection
            $stmt->close();
            // create class error message and resolution
            $this->report[] = array(
              'api' => 'Authenticator',
              'action' => 'send-otp > create-gatekeeper-account > generate-uid > fetch-results',
              'result' => false,
              'message' => '<e><b class="icon-error"></b> Unable to fetch results from mysql query while generating uid!</e>',
              'resolution' => 'reset-login-form'
            );
            return false;
          }

          // if results are successfully fetched, continues to fetch row
          $row = $result->fetch_assoc();
          if(!$row) { // if fails to fetch row closes mysql connection and creates error report
            // unable to fetch row from query results
            // close mysql connection
            $stmt->close();
            // create error report
            $this->report[] = array(
              'api' => 'Authenticator',
              'action' => 'send-otp > create-gatekeeper-account > generate-uid > fetch-row',
              'result' => false,
              'message' => '<e><b class="icon-error"></b> Unable to fetch row from query results while generating uid!</e>',
              'resolution' => 'reset-login-form'
            );
            return false;
          }

          // checks if the number of rows fetched is = 0,
          $this->isUnique = ($row['total'] == 0); // if unique id is achieved closes statement and returns $uid
          if(!$this->isUnique) { // if not continues do loop till unique id is achieved (i.e. $isUniques = 0)
            // the uid created is not unique close mysql connection and create error report
            // close mysql connection
            $stmt->close();
            // create error report
            $this->report[] = array(
              'api' => 'Authenticator',
              'action' => 'send-otp > create-gatekeeper-account > generate-uid > isUnique',
              'result' => false,
              'message' => '<e><b class="icon-error"></b> Found an existing uid match while checking uid uniqueness!</e>',
              'resolution' => 'regenerate-new-uid-and-check-uniqueness'
            );
          }
          $stmt->close();
          // If not unique, generate another id and check again
        } while (!$this->isUnique); // Repeat until a unique id is generated
    // consider limiting uid generation to avoid infinite loop incase the method produces an error
    // create success report
    $this->report[] = array(
        'api' => 'Authenticator',
        'action' => 'send-otp > create-gatekeeper-account > generate-uid',
        'result' => true,
        'message' => '<in><b class="icon-fingerprint"></b>A unique ID was generated and assigned to this email address!</in>',
        'advice' => 'next > create-gatekeeper-account'
    );
    // Return the unique id
    $this->uid = $uid;
    return $uid;
  }
}
?>
