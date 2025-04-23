<?php include 'view_tables_db_connection.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Overview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1500px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table-container {
            font-size: 12px;
        }
        .table thead th {
            background-color: #1aad21;
            color: white;
            text-align: center;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .sticky-header {
            position: sticky;
            top: 0;
            background-color: #007bff;
            z-index: 100;
        }
        th a {
            color: white;
            text-decoration: none;
        }
        th a:hover {
            text-decoration: underline;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn {
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center text-primary mb-4">📊 Project Data Overview</h1>
    
    <div class="text-end">
        <a href="add_data.php" class="btn btn-warning">➕ Add Data</a>
    </div>

    <!-- Search Form -->
    <form method="GET" action="view_table.php" class="mt-4">
        <div class="row g-3">
            <div class="col-md-3"><input type="text" name="customer_name" class="form-control" placeholder="Customer Name" value="<?php echo $_GET['customer_name'] ?? ''; ?>"></div>
            <div class="col-md-3"><input type="text" name="company_name" class="form-control" placeholder="Company Name" value="<?php echo $_GET['company_name'] ?? ''; ?>"></div>
            <div class="col-md-3"><input type="text" name="target_name" class="form-control" placeholder="Target Name" value="<?php echo $_GET['target_name'] ?? ''; ?>"></div>
            <div class="col-md-3"><input type="text" name="chemical_name" class="form-control" placeholder="Chemical Name" value="<?php echo $_GET['chemical_name'] ?? ''; ?>"></div>
        </div>
        <div class="row g-3 mt-2">
            <div class="col-md-3"><input type="text" name="ph" class="form-control" placeholder="PH" value="<?php echo $_GET['ph'] ?? ''; ?>"></div>
            <div class="col-md-3"><input type="text" name="target_achieved" class="form-control" placeholder="Target Achieved" value="<?php echo $_GET['target_achieved'] ?? ''; ?>"></div>
            <div class="col-md-3"><input type="text" name="test_number" class="form-control" placeholder="Test Number" value="<?php echo $_GET['test_number'] ?? ''; ?>"></div>
            <div class="col-md-3"><input type="text" name="ml" class="form-control" placeholder="ML" value="<?php echo $_GET['ml'] ?? ''; ?>"></div>
        </div>
        <div class="row g-3 mt-2">
            <div class="col-md-3"><input type="text" name="project_name" class="form-control" placeholder="Project Name" value="<?php echo $_GET['project_name'] ?? ''; ?>"></div>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">🔍 Search</button>
            <a href="view_table.php" class="btn btn-secondary">🔄 Reset</a>
        </div>
    </form>

    <!-- Table Card -->
    <div class="card mt-4">
        <div class="card-header bg-primary text-white text-center">
            <h5 class="mb-0">📂 Projects</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center table-container">
                    <thead class="table-dark">
                        <tr>
                            <?php
                            $columns = [
                                'project_name' => 'Project Name',
                                'customer_name' => 'Customer Name',
                                'company_name' => 'Company Name',
                                'target_name' => 'Target Name',
                                'expected_initial_concentration' => 'Expected Initial Concentration',
                                'initial_concentration' => 'Initial Concentration',
                                'max_concentration' => 'Max Concentration',
                                'test_number' => 'Test Number',
                                'chemical_name' => 'Chemical Name',
                                'ml' => 'ML',
                                'ph' => 'PH',
                                'time_rpm' => 'Time (RPM)',
                                'target_achieved' => 'Target Achieved',
                                'concentration_mg_l' => 'Concentration (mg/L)',
                                'reduction' => 'Reduction'
                            ];

                            foreach ($columns as $col => $name) {
                                $order = (isset($_GET['sort']) && $_GET['sort'] == $col && $_GET['order'] == 'asc') ? 'desc' : 'asc';
                                echo "<th class='sticky-header'><a href='?sort=$col&order=$order'>$name</a></th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <?php foreach ($columns as $col => $name): ?>
                                    <td><?php echo htmlspecialchars($row[$col]); ?></td>
                                <?php endforeach; ?>
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
