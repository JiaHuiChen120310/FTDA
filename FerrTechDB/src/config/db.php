<?php
$servername = "mysql";
$username = "root";
$password = "Ferr-Tech!120310";  // Update this if needed
$dbname = "testrun_6";  // Changed to correct database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
