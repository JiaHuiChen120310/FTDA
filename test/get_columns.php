<?php
$servername = "localhost";
$username = "root";
$password = "Ferr-Tech!120310";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$table = $_GET['table'];
$columns = [];
$sql = "SHOW COLUMNS FROM `$table`";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $columns[] = $row['Field'];
}

echo json_encode($columns);
$conn->close();
?>
