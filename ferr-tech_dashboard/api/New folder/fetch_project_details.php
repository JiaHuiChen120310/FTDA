<?php
include '../test_code_add_data_db_connection.php';

if (!isset($_GET['project_id'])) {
    echo json_encode(["error" => "Project ID is required"]);
    exit();
}

$project_id = intval($_GET['project_id']);

// Fetch chemicals
$chem_query = "
    SELECT test_number, chemical_name, ml, ph, trpm, added_order 
    FROM chemical_data 
    WHERE project_id = ? 
    ORDER BY test_number ASC, added_order ASC
";
$chem_stmt = $conn->prepare($chem_query);
$chem_stmt->bind_param("i", $project_id);
$chem_stmt->execute();
$chem_result = $chem_stmt->get_result();

$chemicals = [];
$test_numbers = [];

while ($row = $chem_result->fetch_assoc()) {
    $test_num = $row['test_number'];
    $order = $row['added_order'];

    $chemicals[$test_num][$order] = $row;

    if (!in_array($test_num, $test_numbers)) {
        $test_numbers[] = $test_num;
    }
}

sort($test_numbers);

// Fetch treatments
$treatment_query = "
    SELECT t.target_name, tr.target_achieved, tr.concentration, tr.reduction, t.target_order, tr.test_number
    FROM target_data t
    LEFT JOIN treatment_data tr ON t.ID = tr.target_id
    WHERE t.project_id = ?
    ORDER BY tr.test_number ASC, t.target_order ASC
";
$treat_stmt = $conn->prepare($treatment_query);
$treat_stmt->bind_param("i", $project_id);
$treat_stmt->execute();
$treat_result = $treat_stmt->get_result();

$treatments = [];
while ($row = $treat_result->fetch_assoc()) {
    $test_num = $row['test_number'];
    $order = $row['target_order'];
    $treatments[$test_num][$order] = $row;
}

echo json_encode([
    "test_numbers" => $test_numbers,
    "chemicals" => $chemicals,
    "treatments" => $treatments
]);

$conn->close();
?>
