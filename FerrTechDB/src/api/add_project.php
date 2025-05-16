<?php
header('Content-Type: application/json');
require 'add_data_db_connection.php';

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (
    !isset($data['project_name'], $data['sector'], $data['customer_id'],
        $data['target_name'], $data['initial_concentration'], $data['target_order'])
    || !is_array($data['target_name']) || !is_array($data['initial_concentration'])
) {
    echo json_encode(['success' => false, 'message' => 'Missing or invalid input fields.']);
    exit;
}

$project_name = $data['project_name'];
$sector = $data['sector'];
$customer_id = (int)$data['customer_id'];
$target_names = $data['target_name'];
$initial_concentrations = $data['initial_concentration'];
$target_orders = $data['target_order'] ?? [];


// Insert into project_data
$stmt = $conn->prepare("INSERT INTO project_data (project_name, sector, customer_id) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $project_name, $sector, $customer_id);

if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Error inserting project: ' . $stmt->error]);
    exit;
}

$project_id = $stmt->insert_id;
$stmt->close();

// Prepare target insert
$target_stmt = $conn->prepare("INSERT INTO target_data (project_id, target_name, initial_concentration, target_order) VALUES (?, ?, ?, ?)");

foreach ($target_names as $index => $target_name) {
    $initial_conc = floatval($initial_concentrations[$index]);
    $max_conc = isset($max_concentrations[$index]) ? floatval($max_concentrations[$index]) : 0;
    $target_order = isset($target_orders[$index]) ? intval($target_orders[$index]) : ($index + 1);

    $target_stmt->bind_param("issi", $project_id, $target_name, $initial_conc, $target_order);
    $target_stmt->execute();
}

$target_stmt->close();
$conn->close();

echo json_encode(['success' => true, 'message' => 'Project and targets added successfully.']);
?>
