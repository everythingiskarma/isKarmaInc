<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>isKarma Academy</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 5px;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Listing Of Tutorial Ideas</h1>
    <ul>
        <?php
        // Get the current directory
        $directory = __DIR__;

        // Get the list of files in the directory
        $files = scandir($directory);

        // Loop through the files and display them as list items
        foreach ($files as $file) {
            // Exclude current directory (.), parent directory (..), and the index.php file itself
            if ($file != '.' && $file != '..' && $file != basename(__FILE__)) {
                echo '<li><a href="' . $file . '">' . $file . '</a></li>';
            }
        }
        ?>
    </ul>
</body>
</html>
