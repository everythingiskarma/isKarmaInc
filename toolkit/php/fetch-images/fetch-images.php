<?php
// Retrieve the image path from the GET parameter
$imagePath = isset($_GET['image']) ? $_GET['image'] : '';

// Check if the image path is provided and if the file exists
if ($imagePath && file_exists($imagePath)) {
    // Content type mapping for different image extensions
    $contentTypes = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        // Add more mappings for other image types if needed
    ];

    // Get the file extension
    $extension = pathinfo($imagePath, PATHINFO_EXTENSION);

    // Determine the content type based on the file extension
    $contentType = isset($contentTypes[$extension]) ? $contentTypes[$extension] : false;

    // If a valid content type is found, set the appropriate content type header
    if ($contentType) {
        header('Content-Type: ' . $contentType);

        // Output the image data
        readfile($imagePath);
    } else {
        // If the file extension is not supported, send an error response
        header('HTTP/1.1 415 Unsupported Media Type');
        echo "Unsupported image format";
    }
} else {
    // If the image file is not found or no image path is provided, send a 404 error response
    header('HTTP/1.1 404 Not Found');
    echo "Image not found <br/>";
    echo $_GET['image'];
}
?>
