<?php
date_default_timezone_set('UTC'); // Set the default timezone to Coordinated Universal Time

// get current domain
$domain = $_SERVER['HTTP_HOST'];

// Check if the connection is over HTTPS
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {

    // create a custom user session cookie

    // Remove all existing session cookies
    if (!isset($_COOKIE['everythingIsKarma'])) {
        foreach ($_COOKIE as $key => $value) {
            setcookie($key, '', time() - 1441, '/'); // Set expiry time in the past to delete the cookie
        }
    }

    // Set custom name for the session cookie
    session_name('everythingIsKarma');

    // Configure custom cookie parameters
    $cp_lifetime = 1441; // Cookie lifetime in seconds
    $cp_path = '/'; // Cookie path
    $cp_domain = $domain; // Set cookie domain based on request origin
    $cp_secure = true; // Secure flag (set to true if using HTTPS)
    $cp_httponly = true; // HTTPOnly flag
    $cp_samesite = 'Strict'; // set samesite attribute to strict

    // Set custom session cookie parameters
    session_set_cookie_params(
        $cp_lifetime,
        $cp_path,
        $cp_domain,
        $cp_secure,
        $cp_httponly
    );

    // Start the session
    session_start();

    // Set the session cookie with custom parameters
    setcookie(session_name(), session_id(), [
        'expires' => time() + $cp_lifetime,
        'path' => $cp_path,
        'domain' => $cp_domain,
        'secure' => $cp_secure,
        'httponly' => $cp_httponly,
        'samesite' => $cp_samesite
    ]);


} else {
    // Connection is not secure, redirect to the HTTPS version of the page
    $https_url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('Location: ' . $https_url);
    exit();

}

// route the request to respective domain
switch($domain) {
    case "www.iskarma.com":
    case "iskarma.com":
    case "iskarma.local":
        //$domain = "iskarma.com";
        require_once 'iskarma.com/index.php';
        break;
    case "www.iskarma.site":
    case "iskarma.site":
        echo $domain . "<br/>connect to iskarma.site";
        break;
    default:
        $domain = "iskarma.com";
        echo $domain . "<br/>Unknown origin";
}
?>
