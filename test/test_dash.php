<?php
$servername = "localhost";
$username = "root";
$password = "Ferr-Tech!120310";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get all tables
$tables = [];
$sql = "SHOW TABLES";
$result = $conn->query($sql);
while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Database Tables</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="text-center text-primary mb-4">Database Tables</h1>
    <a href="edit_tables.php" class="btn btn-warning mb-3">Edit Tables</a>

    <?php foreach ($tables as $table): ?>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Table: <?php echo strtoupper($table); ?></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <?php
                                $columns = [];
                                $columnResult = $conn->query("SHOW COLUMNS FROM `$table`");
                                while ($col = $columnResult->fetch_assoc()) {
                                    echo "<th>" . $col['Field'] . "</th>";
                                    $columns[] = $col['Field'];
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $dataResult = $conn->query("SELECT * FROM `$table`");
                            while ($row = $dataResult->fetch_assoc()) {
                                echo "<tr>";
                                foreach ($columns as $col) {
                                    echo "<td>{$row[$col]}</td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
