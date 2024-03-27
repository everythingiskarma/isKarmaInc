<?php

$servername = "localhost";
$username = "iskarmac_udbhav";
$password = "getwired";
$database = "iskarmac_test";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL statements to create tables
$sql = "

CREATE DATABASE iskarmac_test;

USE iskarmac_test;

CREATE TABLE `gatekeeper` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `uid` VARCHAR(16) UNIQUE NOT NULL,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `domain` VARCHAR(255) NOT NULL,
  `verified` INT(1) NOT NULL DEFAULT '0',
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `otps` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `uid` VARCHAR(16) UNIQUE NOT NULL,
  `otp` INT(6) NOT NULL DEFAULT '000000',
  `date_issued` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `verified` INT(1) NOT NULL DEFAULT '0',
  `date_verified` DATETIME
);

CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `uid` VARCHAR(16) UNIQUE NOT NULL,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `firstname` VARCHAR(255) NOT NULL DEFAULT 'enter your firstname',
  `lastname` VARCHAR(255) NOT NULL DEFAULT 'enter your lastname',
  `phone` VARCHAR(20),
  `loggedin` INT(1) DEFAULT 0,
  `created` DATETIME,
  `updated` DATETIME
);

CREATE TABLE `users_settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `uid` VARCHAR(16) UNIQUE NOT NULL,
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
  `uid` VARCHAR(16) UNIQUE NOT NULL,
  `login_last` DATETIME,
  `login_attempts` INT DEFAULT 0,
  `login_last_ip` TEXT
);
";

// Execute multi query
if ($conn->multi_query($sql) === TRUE) {
    echo "Tables created successfully";
} else {
    echo "Error creating tables: " . $conn->error;
}

// Close connection
$conn->close();

?>
