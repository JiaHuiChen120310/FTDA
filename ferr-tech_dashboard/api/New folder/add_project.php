<?php
include '../test_code_add_data_db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);

$conn->begin_transaction();
try {
    $stmt = $conn->prepare("INSERT INTO project_data (project_name, sector, customer_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $data['project_name'], $data['sector'], $data['customer_id']);
    $stmt->execute();
    $project_id = $stmt->insert_id;
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO target_data (target_order, target_name, initial_concentration, project_id) VALUES (?, ?, ?, ?)");
    foreach ($data['targets'] as $target) {
        $stmt->bind_param("isdi", $target['order'], $target['name'], $target['initial_concentration'], $project_id);
        $stmt->execute();
    }
    $stmt->close();

    $conn->commit();
    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
$conn->close();
?>
