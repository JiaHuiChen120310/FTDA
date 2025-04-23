<?php
include 'test_code_db_connection.php';

if (!isset($_GET['project_id'])) {
    die("Project ID not provided.");
}

$project_id = intval($_GET['project_id']);

// Fetch Chemicals, grouped by test_number and added_order
$chemicals_query = "
    SELECT test_number, chemical_name, ml, ph, trpm, added_order 
    FROM chemical_data 
    WHERE project_id = ? 
    ORDER BY test_number ASC, added_order ASC";
$chem_stmt = $conn->prepare($chemicals_query);
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

// Fetch Targets and Treatment Results grouped by test_number and target_order
$treatment_query = "
    SELECT t.target_name, tr.target_achieved, tr.concentration, tr.reduction, t.target_order, tr.test_number
    FROM target_data t
    LEFT JOIN treatment_data tr ON t.ID = tr.target_id
    WHERE t.project_id = ?
    ORDER BY tr.test_number ASC, t.target_order ASC";
$treat_stmt = $conn->prepare($treatment_query);
$treat_stmt->bind_param("i", $project_id);
$treat_stmt->execute();
$treatment_result = $treat_stmt->get_result();

$targets = [];
while ($row = $treatment_result->fetch_assoc()) {
    $test_num = $row['test_number'];
    $target_order = $row['target_order'];
    $targets[$test_num][$target_order] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container { overflow-x: auto; }
        .table { font-size: 12px; background-color: lightblue }
        th { white-space: nowrap; }
    </style>
</head>
<body class="bg-secondary">

<div class="container mt-4">
    <h1 class="text-center mb-4">Project Details</h1>

    <div class="overflow-x-auto">
        <table class="table table-striped table-bordered table-dark table-hover">
            <thead>
                <tr>
                    <th>Label</th>
                    <?php foreach ($test_numbers as $test): ?>
                        <th>Test <?= $test ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 1; $i <= 10; $i++): ?>
                    <tr>
                        <th>Chemical <?= $i ?> Name</th>
                        <?php foreach ($test_numbers as $test): ?>
                            <td class="text-capitalize fw-bold"><?= htmlspecialchars($chemicals[$test][$i]['chemical_name'] ?? '') ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <th>ML</th>
                        <?php foreach ($test_numbers as $test): ?>
                            <td><?= htmlspecialchars($chemicals[$test][$i]['ml'] ?? '') ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <th>PH</th>
                        <?php foreach ($test_numbers as $test): ?>
                            <td><?= htmlspecialchars($chemicals[$test][$i]['ph'] ?? '') ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <th>Time x RPM</th>
                        <?php foreach ($test_numbers as $test): ?>
                            <td><?= htmlspecialchars($chemicals[$test][$i]['trpm'] ?? '') ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endfor; ?>

                <?php for ($j = 1; $j <= 5; $j++): ?>
                    <tr>
                        <th>Target <?= $j ?> Name</th>
                        <?php foreach ($test_numbers as $test): ?>
                            <td class="text-capitalize fw-bold"><?= htmlspecialchars($targets[$test][$j]['target_name'] ?? '') ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <th>Achieved</th>
                        <?php foreach ($test_numbers as $test): ?>
                            <td class="text-capitalize"><?= htmlspecialchars($targets[$test][$j]['target_achieved'] ?? '') ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <th>Concentration</th>
                        <?php foreach ($test_numbers as $test): ?>
                            <td><?= htmlspecialchars($targets[$test][$j]['concentration'] ?? '') ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <th>Reduction</th>
                        <?php foreach ($test_numbers as $test): ?>
                            <td><?= htmlspecialchars($targets[$test][$j]['reduction'] ?? '') ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <a href="test_code.php" class="btn btn-dark">Back</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
