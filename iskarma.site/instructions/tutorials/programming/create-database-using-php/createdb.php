<?php

$servername = "localhost";
$username = "udbhav";
$password = "getwired";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failedtet: " . $conn->connect_error);
}

// Create database
$sql_create_db = "CREATE DATABASE IF NOT EXISTS iskarma";
if ($conn->query($sql_create_db) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error;
}

// Select the database
$conn->select_db("iskarma");

// SQL statements to create tables
$sql_create_tables = "
CREATE TABLE `gatekeeper` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `uid` VARCHAR(255) UNIQUE NOT NULL,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `domain` VARCHAR(255) NOT NULL,
  `verified` INT(1) NOT NULL DEFAULT '0',
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `otps` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `uid` VARCHAR(255) UNIQUE NOT NULL,
  `issued` INT(6) NOT NULL DEFAULT '000000',
  `date_issued` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `verified` INT(1) NOT NULL DEFAULT '0',
  `date_verified` DATETIME
);

CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `uid` VARCHAR(255) UNIQUE NOT NULL,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `firstname` VARCHAR(255) NOT NULL DEFAULT 'firstname',
  `lastname` VARCHAR(255) NOT NULL DEFAULT 'lastname',
  `phone` VARCHAR(20),
  `loggedin` INT(1) DEFAULT 0,
  `created` DATETIME,
  `updated` DATETIME
);

CREATE TABLE `users_settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `uid` VARCHAR(255) UNIQUE NOT NULL,
  `2factor` INT(1) DEFAULT 0,
  `2factor_key` VARCHAR(255) UNIQUE,
  `status_newsletter` INT DEFAULT 0,
  `status_notifications` INT DEFAULT 0,
  `status_terms` INT DEFAULT 0,
  `status_privacy` INT DEFAULT 0,
  `status_multisite` INT DEFAULT 0
);

CREATE TABLE `users_activity` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `uid` VARCHAR(255) UNIQUE NOT NULL,
  `login_last` DATETIME,
  `login_attempts` INT DEFAULT 0,
  `login_last_ip` TEXT
);
";

// Execute multi query to create tables
if ($conn->multi_query($sql_create_tables) === TRUE) {
    echo "Tables created successfully";
} else {
    echo "Error creating tables: " . $conn->error;
}

// Close connection
$conn->close();

?>
