<?php
include '../test_code_add_data_db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);
$project_id = intval($data['project_id']);

$stmt = $conn->prepare("SELECT ID, target_name FROM target_data WHERE project_id = ?");
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();

$targets = [];
while ($row = $result->fetch_assoc()) {
    $targets[] = $row;
}

echo json_encode($targets);

$stmt->close();
$conn->close();
?>
