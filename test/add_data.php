<?php 
include 'add_data_db_connection.php';

// Handle Adding Customer
if (isset($_POST['add_customer'])) {
    $stmt = $conn->prepare("INSERT INTO customer_data (customer_name, company_name, address, email, phone, website) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $_POST['customer_name'], $_POST['company_name'], $_POST['address'], $_POST['email'], $_POST['phone'], $_POST['website']);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Adding Project
if (isset($_POST['add_project'])) {
    $stmt = $conn->prepare("INSERT INTO projects (project_name, target_name, expected_initial_concentration, initial_concentration, max_concentration, customer_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdddi", $_POST['project_name'], $_POST['target_name'], $_POST['expected_initial_concentration'], $_POST['initial_concentration'], $_POST['max_concentration'], $_POST['customer_id']);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Adding Analysis
if (isset($_POST['add_analysis'])) {
    $stmt = $conn->prepare("INSERT INTO analysis (test_number, chemical_name, ml, ph, time_rpm, target_achieved, concentration_mg_l, reduction, project_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddssddi", $_POST['test_number'], $_POST['chemical_name'], $_POST['ml'], $_POST['ph'], $_POST['timeXrpm'], $_POST['target_achieved'], $_POST['concentration_mg_l'], $_POST['reduction'], $_POST['project_id']);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 900px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            color: #343a40;
        }
        .nav-tabs .nav-link {
            font-weight: bold;
            color: #495057;
        }
        .nav-tabs .nav-link.active {
            background-color: #007bff;
            color: white;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-primary, .btn-warning {
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="container">
        <h2>Manage Data</h2>
        <div class="text-center mb-3">
            <a href="view_table.php" class="btn btn-warning">View Table</a>
        </div>

        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs" id="dataTabs">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#addCustomer">Add Customer</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#addProject">Add Project</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#addAnalysis">Add Analysis</a></li>
        </ul>

        <div class="tab-content mt-3">
            <!-- Add Customer Tab -->
            <div id="addCustomer" class="tab-pane fade show active">
                <h4>Add Customer</h4>
                <form method="POST">
                    <div class="mb-3"><label class="form-label">Customer Name</label><input type="text" name="customer_name" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Company Name</label><input type="text" name="company_name" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Address</label><input type="text" name="address" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Website</label><input type="text" name="website" class="form-control"></div>
                    <button type="submit" name="add_customer" class="btn btn-primary w-100">Add Customer</button>
                </form>
            </div>

            <!-- Add Project Tab -->
            <div id="addProject" class="tab-pane fade">
                <h4>Add Project</h4>
                <form method="POST">
                    <div class="mb-3"><label class="form-label">Project Name</label><input type="text" name="project_name" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Target Name</label><input type="text" name="target_name" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Expected Initial Concentration</label><input type="number" step="0.01" name="expected_initial_concentration" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Initial Concentration</label><input type="number" step="0.01" name="initial_concentration" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Max Concentration</label><input type="number" step="0.01" name="max_concentration" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Customer</label>
                        <select name="customer_id" class="form-control" required>
                            <option value="">Select Customer</option>
                            <?php
                            $customers = $conn->query("SELECT customer_id, customer_name FROM customer_data");
                            while ($row = $customers->fetch_assoc()) {
                                echo "<option value='{$row['customer_id']}'>{$row['customer_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" name="add_project" class="btn btn-primary w-100">Add Project</button>
                </form>
            </div>
			
			<div id="addAnalysis" class="tab-pane fade">
            <h4>Add Analysis</h4>
            <form method="POST">
                <div class="mb-3"><label class="form-label">Test Number</label><input type="text" name="test_number" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Chemical Name</label><input type="text" name="chemical_name" class="form-control"></div>
                <div class="mb-3"><label class="form-label">Volume (mL)</label><input type="number" step="0.01" name="ml" class="form-control"></div>
                <div class="mb-3"><label class="form-label">PH</label><input type="number" step="0.01" name="ph" class="form-control"></div>
                <div class="mb-3"><label class="form-label">Time x RPM</label><input type="text" name="timeXrpm" class="form-control"></div>
				<div class="mb-3"><label class="form-label">Target Achieved</label><input type="text" name="target_achieved" class="form-control"></div>
				<div class="mb-3"><label class="form-label">Concentration(mg/L)</label><input type="number"  step="0.01" name="concentration_mg_l" class="form-control"></div>
				<div class="mb-3"><label class="form-label">Reduction</label><input type="number" name="reduction" class="form-control"></div>
                <div class="mb-3"><label class="form-label">Project</label>
                    <select name="project_id" class="form-control" required>
                        <option value="">Select Project</option>
                        <?php
                        $projects = $conn->query("SELECT project_id, project_name FROM projects");
                        while ($row = $projects->fetch_assoc()) {
                            echo "<option value='{$row['project_id']}'>{$row['project_name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="add_analysis" class="btn btn-primary w-100">Add Analysis</button>
            </form>
        </div>
        </div>
    </div>

</body>
</html>
