<?php
$servername = "localhost";
$username = "root";
$password = "Ferr-Tech!120310";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "
    SELECT 
        p.project_id, 
        p.project_number, 
        p.company_name, 
        p.client_name, 
        i.industry_name, 
        p.receival_date, 
        p.test_date, 
        ca.test_number, 
        ca.chemical_name, 
        ca.volume_ml, 
        ca.pH, 
        ca.time_rpm, 
        ca.result, 
        pr.protocol_description, 
        t.target_name, 
        t.expected_initial_concentration, 
        t.max_concentration 
    FROM projects p
    LEFT JOIN industry_list i ON p.industry = i.industry_name
    LEFT JOIN chemical_analysis ca ON p.project_id = ca.project_id
    LEFT JOIN protocols pr ON p.project_id = pr.project_id
    LEFT JOIN target_information t ON p.project_id = t.project_id
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Overview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="text-center text-primary mb-4">Database Overview</h1>
    <a href="add_data.php" class="btn btn-warning mb-3">Add Data</a>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">All Linked Data</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Project Number</th>
                            <th>Company Name</th>
                            <th>Client Name</th>
                            <th>Industry</th>
                            <th>Receival Date</th>
                            <th>Test Date</th>
                            <th>Test Number</th>
                            <th>Chemical Name</th>
                            <th>Volume (ml)</th>
                            <th>PH</th>
                            <th>Time (RPM)</th>
                            <th>Result</th>
                            <th>Protocol Description</th>
                            <th>Target Name</th>
                            <th>Initial Concentration</th>
                            <th>Max Concentration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['project_number']; ?></td>
                                <td><?php echo $row['company_name']; ?></td>
                                <td><?php echo $row['client_name']; ?></td>
                                <td><?php echo $row['industry_name']; ?></td>
                                <td><?php echo $row['receival_date']; ?></td>
                                <td><?php echo $row['test_date']; ?></td>
                                <td><?php echo $row['test_number']; ?></td>
                                <td><?php echo $row['chemical_name']; ?></td>
                                <td><?php echo $row['volume_ml']; ?></td>
                                <td><?php echo $row['pH']; ?></td>
                                <td><?php echo $row['time_rpm']; ?></td>
                                <td><?php echo $row['result']; ?></td>
                                <td><?php echo $row['protocol_description']; ?></td>
                                <td><?php echo $row['target_name']; ?></td>
                                <td><?php echo $row['expected_initial_concentration']; ?></td>
                                <td><?php echo $row['max_concentration']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
