<?php
include '../test_code_add_data_db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $conn->prepare("INSERT INTO customer_data (customer_name, company_name, address, email, phone) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $data['customer_name'], $data['company_name'], $data['address'], $data['email'], $data['phone']);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
