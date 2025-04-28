<?php
$servername = "localhost";
$username = "root";
$password = "Ferr-Tech!120310";
$dbname = "testrun_6";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
