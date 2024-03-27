<?php

class Encryption {
    private $key;

    public function __construct($key) {
        $this->key = $key;
    }

    public function encrypt($data) {
        // Generate initialization vector (IV)
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

        // Encrypt the data using AES-256-CBC encryption algorithm
        $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $this->key, 0, $iv);

        // Concatenate IV and encrypted data for storage or transmission
        $encryptedMessage = $iv . $encryptedData;

        return base64_encode($encryptedMessage); // Encode the encrypted message as base64 for storage or transmission
    }

    public function decrypt($encryptedMessage) {
        // Decode the base64-encoded encrypted message
        $encryptedMessage = base64_decode($encryptedMessage);

        // Extract initialization vector (IV) from the encrypted message
        $ivLength = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr($encryptedMessage, 0, $ivLength);

        // Extract the encrypted data from the encrypted message
        $encryptedData = substr($encryptedMessage, $ivLength);

        // Decrypt the data using AES-256-CBC decryption algorithm
        $decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', $this->key, 0, $iv);

        return $decryptedData;
    }
}

// Generate a random encryption key
function generateEncryptionKey($length) {
    return bin2hex(random_bytes($length / 2)); // Convert random bytes to hexadecimal string
}

// Example usage:
$key = generateEncryptionKey(32); // Generate a 256-bit (32-byte) encryption key
$encryption = new Encryption($key);

// Data to encrypt
$data = "text to be encrypted";

// Encrypt the data
$encryptedMessage = $encryption->encrypt($data);

echo "Encrypted Message: <br/>" . $encryptedMessage . "\n<br/><br/>";

// Decrypt the encrypted message
$decryptedData = $encryption->decrypt($encryptedMessage);

echo "Decrypted Data: <br/>" . $decryptedData . "\n";

?>
