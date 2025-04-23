<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "Ferr-Tech!120310";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

if (isset($_GET['table'])) {
    $table = $conn->real_escape_string($_GET['table']);
    $columns = [];
    
    $result = $conn->query("SHOW COLUMNS FROM `$table`");
    while ($row = $result->fetch_assoc()) {
        // Exclude AUTO_INCREMENT and DEFAULT columns
        if (strpos($row['Extra'], 'auto_increment') === false && $row['Default'] === null) {
            $columns[] = $row['Field'];
        }
    }

    echo json_encode($columns);
}
?>
