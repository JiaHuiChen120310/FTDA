<?php
header('Content-Type: application/json');
include 'add_data_db_connection.php';

$sql = "SELECT id, customer_name FROM customer_data ORDER BY customer_name ASC";
$result = $conn->query($sql);

$customers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $customers[] = [
            'id' => $row['id'],
            'name' => $row['customer_name']
        ];
    }
} else {
    // If no customers found, send an empty array or a message
    $customers = [];
}

// Set header to indicate that the content is JSON
header('Content-Type: application/json');
echo json_encode($customers);

$conn->close();
?>
