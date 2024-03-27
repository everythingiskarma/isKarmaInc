<!doctype html>
<html lang="en">
<?php
// index.php

// Mapping of page names to content
$pages = [
    'home' => 'This is the home page.',
    'about' => 'This is the about page.',
    'contact' => 'This is the contact page.'
];

// Get the requested page
$requestedPage = isset($_GET['page']) ? $_GET['page'] : 'home';

// Check if the requested page exists, otherwise display a 404 message
if (array_key_exists($requestedPage, $pages)) {
    echo $pages[$requestedPage];
} else {
    http_response_code(404);
    echo 'Page not found.';
}
?>
</html>
