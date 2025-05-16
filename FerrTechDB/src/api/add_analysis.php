<?php
header('Content-Type: application/json');

require 'add_data_db_connection.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'Invalid JSON.']);
        exit;
    }

    $project_id = $data['project_id'];
    $test_number = $data['test_number'];

    // $chemicals = $data['chemicals']; // comment this out
    //$treatments = $data['treatments']; // comment this out

    //add this: extract flat arrays from input
    $chemical_names = $data['chemical_name'];
    $mls = $data['ml'];
    $phs = $data['ph'];
    $trpms = $data['trpm'];

    $chemical_stmt = $conn->prepare("INSERT INTO chemical_data (project_id, test_number, chemical_name, ml, ph, trpm, added_order) VALUES (?, ?, ?, ?, ?, ?, ?)");

    for ($i = 0; $i < count($chemical_names); $i++) {
        if (!empty($chemical_names[$i])) {
            $ml = floatval($mls[$i]) ?: 0;
            $ph = floatval($phs[$i]) ?: 0;
            $trpm = floatval(preg_replace('/[^0-9.]/', '', $trpms[$i])) ?: 0; // sanitize if necessary

            $chemical_name = $chemical_names[$i]; // add this
			$add_order = $i + 1; // add this

			$chemical_stmt->bind_param(
				"issdddi",
				$project_id,
				$test_number,
				$chemical_name,
				$ml,
				$ph,
				$trpm,
				$add_order
			);
            $chemical_stmt->execute();
        }
    }

    $chemical_stmt->close();

    //add this: treatment data from flat arrays
    $target_ids = $data['target_id'];
    $target_achieved = $data['target_achieved'];
    $concentrations = $data['concentration'];
    $reductions = $data['reduction'];

    $treatment_stmt = $conn->prepare("INSERT INTO treatment_data (target_id, test_number, target_achieved, concentration, reduction) VALUES (?, ?, ?, ?, ?)");

    for ($j = 0; $j < count($target_ids); $j++) {
        if (!empty($target_ids[$j])) {
            $achieved = $target_achieved[$j] ?? '';
            $conc = floatval($concentrations[$j]) ?: 0;
            $reduction = floatval($reductions[$j]) ?: 0;

            $target_id = $target_ids[$j];
			
			$treatment_stmt->bind_param(
                "iisdd",
                $target_id,
                $test_number,
                $achieved,
                $conc,
                $reduction
            );
            $treatment_stmt->execute();
        }
    }

    file_put_contents('log.txt', print_r($data, true));
    $treatment_stmt->close();
    $conn->close();

    echo json_encode(['success' => true, 'message' => 'Analysis data added successfully.']);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}
