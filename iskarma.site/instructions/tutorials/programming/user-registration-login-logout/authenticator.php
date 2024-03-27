<?php
session_start();

// Function to generate a random 6-digit OTP
function generateOTP() {
  return mt_rand(100000, 999999);
}

// Function to send OTP via email (you need to implement this function)
function sendOTPByEmail($email, $otp) {
  // Implement code to send OTP to the provided email addresstest
  // Example: mail($email, "Your OTP for authentication", "Your OTP is: " . $otp);
  // will implement this when we have an email server running.
  $to = $email;
  $subject = "Your One-Time Password (OTP)";
  $message = "Your OTP is: $otp";
  $headers = "From: iskarma@proton.me";
  // send mail
  if(mail($to, $subject, $message, $headers)) {
    // email sent successfully
    return true;
  } else {
    return false;
  }
}


// Function to hand logout

function logout() {
  if(isset($_SESSION['loggedin'])) {
    // unset all session variables.
    $_SESSION = array();
    // Destroy the session cookie
    if(ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
      );
    }

    // Destroy the session
    session_destroy();

    // update the users table to change the value of `loggedin` to 0
    if(isset($_SESSION['uid'])) {
      $uid = $_SESSION['uid'];
      $sql = "UPDATE users SET loggedin=0 WHERE uid='$uid'";
    }

    // send logout confirmation message
    echo "you have successfully logged out!";
  }
}

if(isset($_POST['logout']) && isset($_SESSION['uid'])) {
  logout();
}

// Function to handle email authentication and OTP generation
if(isset($_POST['email'])) {
  $email = $_POST['email'];

  // Check if email exists in the database
  $sql = "SELECT * FROM users WHERE email='$email'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Email already registered, generate OTP for login
    $row = $result->fetch_assoc();
    $uid = $row['uid'];
    $type = 1; // OTP for registered account
  } else {
    // Email not registered, create new account
    $uid = uniqid(); // Generate unique user ID
    $type = 0; // OTP for new registration

    // Insert email into gatekeeper table
    $sql = "INSERT INTO gatekeeper (uid, email, domain, verified) VALUES ('$uid', '$email', '', 0)";
    $conn->query($sql);
  }

  // Generate OTP
  $otp = generateOTP();

  // Store OTP in database
  $sql = "INSERT INTO otps (uid, type, issued, verified) VALUES ('$uid', $type, $otp, 0)";
  $conn->query($sql);

  // Send OTP via email
  // sendOTPByEmail($email, $otp);

  // Send response to client
  echo json_encode(array("success" => true, "type" => $type, "uid" => $uid, "otp" => $otp));
  exit();
}

// Function to handle OTP verification
if(isset($_POST['otp'])) {

  $uid = $_POST['uid'];

  $otp = $_POST['otp'];

  // Retrieve OTP from database
  $sql = "SELECT * FROM otps WHERE uid='$uid' AND issued='$otp' AND verified=0";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // OTP verification successful
    $row = $result->fetch_assoc();
    $type = $row['type'];

    // Mark OTP as verified
    $sql = "UPDATE otps SET verified=1 WHERE uid='$uid' AND issued='$otp'";
    $conn->query($sql);

    // Set loggedin status in users table
    if ($type == 0) {
      // New registration
      $sql = "UPDATE gatekeeper SET verified=1 WHERE uid='$uid'";
      $conn->query($sql);
      // You can handle account verification and creation here
    } else {
      // Existing user login

      $sql = "UPDATE users SET loggedin=1 WHERE uid='$uid'";
      $conn->query($sql);
      $_SESSION['loggedin'] = $uid; // Start session for logged-in user
      // You can redirect user to dashboard or profile page here
    }

    echo json_encode(array("success" => true));
    exit();
  } else {
    // OTP verification failed
    echo json_encode(array("success" => false, "message" => "Invalid OTP"));
    exit();
  }

}
?>
ert email into gatekeeper table
    $sql = "INSERT INTO gatekeeper (uid, email, domain, verified) VALUES ('$uid', '$email', '', 0)";
    $conn->query($sql);
  }

  // Generate OTP
  $otp = generateOTP();

  // Store OTP in database
  $sql = "INSERT INTO otps (uid, type, issued, verified) VALUES ('$uid', $type, $otp, 0)";
  $conn->query($sql);

  // Send OTP via email
  // sendOTPByEmail($email, $otp);

  // Send response to client
  echo json_encode(array("success" => true, "type" => $type, "uid" => $uid, "otp" => $otp));
  exit();
}

// Function to handle OTP verification
if(isset($_POST['otp'])) {

  $uid = $_POST['uid'];

  $otp = $_POST['otp'];

  // Retrieve OTP from database
  $sql = "SELECT * FROM otps WHERE uid='$uid' AND issued='$otp' AND verified=0";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // OTP verification successful
    $row = $result->fetch_assoc();
    $type = $row['type'];

    // Mark OTP as verified
    $sql = "UPDATE otps SET verified=1 WHERE uid='$uid' AND issued='$otp'";
    $conn->query($sql);

    // Set loggedin status in users table
    if ($type == 0) {
      // New registration
      $sql = "UPDATE gatekeeper SET verified=1 WHERE uid='$uid'";
      $conn->query($sql);
      // You can handle account verification and creation here
    } else {
      // Existing user login

      $sql = "UPDATE users SET loggedin=1 WHERE uid='$uid'";
      $conn->query($sql);
      $_SESSION['loggedin'] = $uid; // Start session for logged-in user
      // You can redirect user to dashboard or profile page here
    }

    echo json_encode(array("success" => true));
    exit();
  } else {
    // OTP verification failed
    echo json_encode(array("success" => false, "message" => "Invalid OTP"));
    exit();
  }

}
?>
