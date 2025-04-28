<?php
header('Content-Type: application/json');
require 'add_data_db_connection.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['project_id'], $data['test_number'], $data['chemicals'], $data['treatments'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit;
}

$project_id = $data['project_id'];
$test_number = $data['test_number'];
$chemicals = $data['chemicals'];
$treatments = $data['treatments'];

// Insert chemical data
$chemical_stmt = $conn->prepare("INSERT INTO chemical_data (project_id, test_number, chemical_name, ml, ph, trmp, added_order) VALUES (?, ?, ?, ?, ?, ?, ?)");

foreach ($chemicals as $index => $chem) {
    $chemical_name = $chem['chemical_name'] ?? '';
    $ml = $chem['ml'] ?? 0;
    $ph = $chem['ph'] ?? 0;
    $trmp = $chem['trmp'] ?? 0;
    $add_order = $index + 1;

    $chemical_stmt->bind_param("issdddi", $project_id, $test_number, $chemical_name, $ml, $ph, $trmp, $add_order);
    $chemical_stmt->execute();
}

$chemical_stmt->close();

// Insert treatment data
$treatment_stmt = $conn->prepare("INSERT INTO treatment_data (project_id, test_number, target_id, target_achieved, concentration, reduction) VALUES (?, ?, ?, ?, ?, ?)");

foreach ($treatments as $treat) {
    $target_id = $treat['target_id'];
    $achieved = $treat['target_achieved'];
    $conc = $treat['concentration'];
    $reduction = $treat['reduction'];

    $treatment_stmt->bind_param("iisddd", $project_id, $test_number, $target_id, $achieved, $conc, $reduction);
    $treatment_stmt->execute();
}

$treatment_stmt->close();
$conn->close();

echo json_encode(['success' => true, 'message' => 'Analysis data added successfully.']);
?>
