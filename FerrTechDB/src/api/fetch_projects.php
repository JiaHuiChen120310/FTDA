<?php
header('Content-Type: application/json');
include 'add_data_db_connection.php';

$sql = "SELECT id, project_name FROM project_data ORDER BY project_name ASC";
$result = $conn->query($sql);

$projects = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = [
            'id' => $row['id'],
            'name' => $row['project_name']
        ];
    }
} else {
    // If no projects found, send an empty array or a message
    $projects = [];
}

// Set header to indicate that the content is JSON
header('Content-Type: application/json');
echo json_encode($projects);

$conn->close();
?>
