<?php
header('Content-Type: application/json');
require 'add_data_db_connection.php';

// Decode raw JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (!isset($data['customer_name'], $data['company_name'], $data['email'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit;
}

$customer_name = $data['customer_name'];
$company_name = $data['company_name'];
$address = $data['address'] ?? '';
$email = $data['email'];
$phone = $data['phone'] ?? '';

// Prepare and execute insert
$stmt = $conn->prepare("INSERT INTO customer_data (customer_name, company_name, address, email, phone) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $customer_name, $company_name, $address, $email, $phone);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Customer added successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
