<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit;
}

// Read raw POST body
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['success' => false, 'error' => 'Invalid JSON input']);
    exit;
}

// Ensure all expected keys are set (Sector, cod(before), chem1-chem10 + doses)
$preparedInput = [
    'Sector' => $input['Sector'] ?? '',
    'cod_before' => isset($input['cod_before']) ? floatval($input['cod_before']) : 0.0
];

// Add chem1–chem10 and corresponding doses
for ($i = 1; $i <= 10; $i++) {
    $chemKey = "chem{$i}";
    $doseKey = "chem{$i}_dose";

    $preparedInput[$chemKey] = $input[$chemKey] ?? '';
    $preparedInput[$doseKey] = isset($input[$doseKey]) ? floatval($input[$doseKey]) : 0.0;
}

// Run Python script
$command = 'python ../ml_model/cod_predict_wrapper.py';
$process = proc_open($command, [
    0 => ["pipe", "r"],  // stdin
    1 => ["pipe", "w"],  // stdout
    2 => ["pipe", "w"]   // stderr
], $pipes);

if (is_resource($process)) {
    fwrite($pipes[0], json_encode($preparedInput));
    fclose($pipes[0]);

    $result = stream_get_contents($pipes[1]);
    fclose($pipes[1]);

    $error = stream_get_contents($pipes[2]);
    fclose($pipes[2]);

    $return_value = proc_close($process);

    if ($return_value !== 0) {
        echo json_encode(['success' => false, 'error' => $error]);
    } else {
        $prediction = json_decode($result, true);
        if (json_last_error() === JSON_ERROR_NONE && isset($prediction['prediction'])) {
            echo json_encode(['success' => true, 'prediction' => $prediction['prediction']]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid prediction response']);
        }
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to start Python process']);
}
?>
