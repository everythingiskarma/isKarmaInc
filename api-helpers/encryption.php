<?php
// include the database connection class ConDb
require_once 'connect.php'; // inherits from Database.php

// create class to encrypt and decrypt data
class Encryption extends Connect {

  private $uid; // user id whose encryption key will be fetched
  private $gatepass; // Encryptin key retrieved from the database

  public function __construct($uid) {
    parent::__construct();
    $this->uid = $uid;
    $this->fetchEncryptionKey();
  }

  private function fetchEncryptionKey() {
    // query database to retrieve users encryption key
    $fetchGatepass = "SELECT gatepass FROM user WHERE id = ?";
    $stmt = $this->getConnection()->prepare($fetchGatepass);
    if(!$stmt) {
      // failed to prepare statement
      // create class response failure message
      $this->error[] = array(
        'api' => 'Encryption',
        'action' => 'prepare-query-fetch-gatepass',
        'success' => false,
        'message' => 'Error: Failed to prepare query while fetching gatepass',
        'resolution' => 'retry'
      );
      return false;
    } else {
      // statement prepared successfully, continue to bind parameters and execute statement
      $stmt->bind_param("s", $this->uid);
      if(!$stmt->execute()) {
        // unable to execute statement
        // create class response failure message
        $this->error[] = array(
          'api' => 'Encryption',
          'action' => 'execute-query-fetch-gatepass',
          'success' => false,
          'message' => 'Error: Failed to execute statement while fetching gatepass',
          'resolution' => 'retry'
        );
        return false;
      } else {
        // statement successfully executed, continue to get result
        $result = $stmt->get_result();
        if(!$result) {
          $stmt->close();
          // failed to fetch results
          // create class response failure message
          $this->error[] = array(
            'api' => 'Encryption',
            'action' => 'get-results-fetch-gatepass',
            'success' => false,
            'message' => '<e><b class="icon-error"></b>Failed to get results while fetching gatepass</e>',
            'resolution' => 'retry'
          );
          return false;
        }
      }
    }

    if($row = $result->fetch_assoc()) {
      // get the encryption key from user account
      $this->key = $row['gatepass']; // this is the column where encryption key is stored in users table
      $this->success[] = array(
        'api' => 'Encryption',
        'action' => 'fetch-gatepass',
        'success' => true,
        'message' => '<s><b class="icon-done-all"></b> Encryption key successfully generated</s>',
        'response' => $this->key
      );
    } else {
      // encryption key not found assign a default encryption key.
      $this->key = "WoF6B1R3B+mwKFxkKv5BsncxV3pYVjYyb2xHUVpQbXdWWTlZZkplVzc1RERKbXBXQkp4Q3l2QlBZTUE9";
      $this->error[] = array(
        'api' => 'Encryption',
        'action' => 'fetch-gatepass',
        'success' => false,
        'message' => 'Error: No encryption Key Found!',
        'content' => $this->key
      );
    }
  }

  public function encrypt($data) {
    // generate initialization vector (IV);
    $ivSize = openssl_cipher_iv_length('aes-256-cbc');
    $iv = openssl_random_pseudo_bytes($ivSize);

    // Encrypt data using AES encryption algorithm
    $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, $iv);

    // Combine IV and encrypted data
    $encryptedDataWithIV = $iv . $encryptedData;

    // Base64 encode the result for safe storage
    $encryptedDataBase64 = base64_encode($encryptedDataWithIV);

    $this->encryptionResponses[] = array(
      'action' => 'encrypt-data',
      'success' => true,
      'content' => $encryptedDataBase64
    );
    return $encryptedDataBase64;
  }

  public function decrypt($data) {
    // Base64 decode the encrypted data
    $encryptedDataWithIV = base64_decode($encryptedData);

    // Extract IV from the combined IV and encrypted data
    $ivSize = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($encryptedDataWithIV, 0, $ivSize);

    // Extract encrypted data excluding IV
    $encryptedData = substr($encryptedDataWithIV, $ivSize);

    // Decrypt data using the AES decryption algorithm
    $decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, $iv);

    $this->encryptionResponses[] = array(
      'action' => 'decrypt-data',
      'success' => true,
      'content' => $decryptedData
    );
    return $decryptedData;
  }
}

// initiate an instance of the class Encryption
//$db = Encryption::getInstance();

// Output the responses as JSON
//echo json_encode($db->encryptionResponses);
?>
