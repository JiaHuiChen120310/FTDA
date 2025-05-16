<?php
header('Content-Type: application/json');
require 'project_detail_db_connection.php';

if (!isset($_GET['project_id'])) {
    echo json_encode(['success' => false, 'message' => 'Project ID not provided.']);
    exit;
}

$project_id = intval($_GET['project_id']);

// Fetch Chemicals
$chem_stmt = $conn->prepare("
    SELECT test_number, chemical_name, ml, ph, trpm, added_order 
    FROM chemical_data 
    WHERE project_id = ? 
    ORDER BY test_number ASC, added_order ASC
");
$chem_stmt->bind_param("i", $project_id);
$chem_stmt->execute();
$chemicals_result = $chem_stmt->get_result();

$chemicals = [];
$test_numbers = [];

while ($row = $chemicals_result->fetch_assoc()) {
    $test_num = $row['test_number'];
    $order = $row['added_order'];
    $chemicals[$test_num][$order] = $row;
    if (!in_array($test_num, $test_numbers)) {
        $test_numbers[] = $test_num;
    }
}

sort($test_numbers);

// Fetch Targets and Treatments
$treat_stmt = $conn->prepare("
    SELECT t.target_name, tr.target_achieved, tr.concentration, tr.reduction, t.target_order, tr.test_number
    FROM target_data t
    LEFT JOIN treatment_data tr ON t.ID = tr.target_id
    WHERE t.project_id = ?
    ORDER BY tr.test_number ASC, t.target_order ASC
");
$treat_stmt->bind_param("i", $project_id);
$treat_stmt->execute();
$treatment_result = $treat_stmt->get_result();

$targets = [];
while ($row = $treatment_result->fetch_assoc()) {
    $test_num = $row['test_number'];
    $target_order = $row['target_order'];
    $targets[$test_num][$target_order] = $row;
}

echo json_encode([
    'success' => true,
    'test_numbers' => $test_numbers,
    'chemicals' => $chemicals,
    'targets' => $targets
]);
?>
