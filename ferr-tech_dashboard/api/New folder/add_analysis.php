<?php
include '../test_code_add_data_db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);
$conn->begin_transaction();

try {
    $project_id = $data['project_id'];
    $test_number = $data['test_number'];

    // Chemicals
    $stmt = $conn->prepare("INSERT INTO chemical_data (test_number, added_order, chemical_name, ml, ph, trpm, project_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($data['chemicals'] as $chem) {
        $stmt->bind_param("iisddsi", $test_number, $chem['order'], $chem['name'], $chem['ml'], $chem['ph'], $chem['trmp'], $project_id);
        $stmt->execute();
    }
    $stmt->close();

    // Treatments
    $stmt = $conn->prepare("INSERT INTO treatment_data (target_id, test_number, target_achieved, concentration, reduction) VALUES (?, ?, ?, ?, ?)");
    foreach ($data['treatments'] as $treat) {
        $stmt->bind_param("iisdd", $treat['target_id'], $test_number, $treat['target_achieved'], $treat['concentration'], $treat['reduction']);
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
