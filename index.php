<?php
date_default_timezone_set('UTC'); // Set the default timezone to Coordinated Universal Time

// create a custom user session cookie
require_once 'session.php';

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
