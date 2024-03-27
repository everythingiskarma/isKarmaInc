<?php
// SMTP server settings
$smtpServer = 'smtps://mail.iskarma.com:465';
$username = 'authenticator@iskarma.com'; // Your email address
$password = 'xcZwOpo7flL2'; // Your email password


$from = 'authenticator@iskarma.com';
$to = 'support@iskarma.com';

// Email headers and content
$subject = 'Test Email';
$message = "From: $from\nTo: $to\nSubject: $subject\n\nBody of the email";

// Initialize cURL session
$curl = curl_init();

// Set cURL options
curl_setopt($curl, CURLOPT_URL, $smtpServer);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'SMTP');
curl_setopt($curl, CURLOPT_MAIL_FROM, $from);
curl_setopt($curl, CURLOPT_RCPTTO, array($to));
curl_setopt($curl, CURLOPT_USERNAME, $username);
curl_setopt($curl, CURLOPT_PASSWORD, $password);
curl_setopt($curl, CURLOPT_UPLOAD, true);
curl_setopt($curl, CURLOPT_INFILESIZE, strlen($message));
curl_setopt($curl, CURLOPT_INFILE, fopen('data://text/plain,' . $message, 'r'));

// Execute cURL request
$response = curl_exec($curl);

// Check for errors
if ($response === false) {
    echo 'Error: ' . curl_error($curl);
} else {
    echo 'Email sent successfully.';
}

// Close cURL session
curl_close($curl);
?>
