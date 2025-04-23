<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root"; // Default XAMPP user
$password = "Ferr-Tech!120310"; // Default XAMPP password (empty)
$dbname = "test_db"; // Change this to your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("<div class='alert alert-danger text-center'>Database Connection Failed: " . $conn->connect_error . "</div>");
}

// Fetch all tables
$tables = [];
$result = $conn->query("SHOW TABLES");
while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    foreach ($tables as $table) {
        if (isset($_POST[$table])) {
            $columns = [];
            $values = [];
            $updates = [];

            foreach ($_POST[$table] as $col => $value) {
                if (!empty($value)) { // Only insert non-empty fields
                    $columns[] = "`$col`";
                    $values[] = "'" . $conn->real_escape_string($value) . "'";
                    $updates[] = "`$col`=VALUES(`$col`)"; // Handles duplicates
                }
            }

            if (!empty($columns)) {
                // Prevents duplicate errors and updates existing records
                $sql = "INSERT INTO `$table` (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $values) . ") 
                        ON DUPLICATE KEY UPDATE " . implode(", ", $updates);
                
                if (!$conn->query($sql)) {
                    $errors[] = "Error inserting into `$table`: " . $conn->error;
                }
            }
        }
    }

    if (empty($errors)) {
        echo "<div class='alert alert-success text-center'>All tables updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>" . implode("<br>", $errors) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update All Tables</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2 class="text-center">Update All Tables</h2>

    <form method="POST" class="mt-3">
        <?php foreach ($tables as $table) { ?>
            <h4 class="mt-4"><?= ucfirst($table) ?></h4>
            <div id="form-fields-<?= $table ?>"></div>
        <?php } ?>

        <button type="submit" class="btn btn-primary mt-4">Submit</button>
    </form>

    <script>
        const tables = <?= json_encode($tables) ?>;

        tables.forEach(table => {
            fetch(`fetch_columns.php?table=${table}`)
                .then(response => response.json())
                .then(data => {
                    let formFields = document.getElementById(`form-fields-${table}`);
                    data.forEach(column => {
                        if (column !== "id") { // Skip auto-increment ID
                            formFields.innerHTML += `
                                <div class="mb-3">
                                    <label class="form-label">${column} (${table})</label>
                                    <input type="text" name="${table}[${column}]" class="form-control">
                                </div>`;
                        }
                    });
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

</body>
</html>
