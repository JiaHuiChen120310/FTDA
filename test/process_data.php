<?php
include 'test_code_add_data_db_connection.php';

// Add Customer
if (isset($_POST['add_customer'])) {
    $stmt = $conn->prepare("INSERT INTO customer_data (customer_name, company_name, address, email, phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $_POST['customer_name'], $_POST['company_name'], $_POST['address'], $_POST['email'], $_POST['phone']);
    $stmt->execute();
    $stmt->close();
    header("Location: test_code_add_data.php");
    exit();
}

// Add Project and Targets
if (isset($_POST['add_project'])) {
    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare("INSERT INTO project_data (project_name, sector, customer_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $_POST['project_name'], $_POST['sector'], $_POST['customer_id']);
        $stmt->execute();
        $project_id = $stmt->insert_id;
        $stmt->close();

        if (!empty($_POST['target_name'])) {
            $stmt = $conn->prepare("INSERT INTO target_data (target_order, target_name, initial_concentration, project_id) VALUES (?, ?, ?, ?)");
            foreach ($_POST['target_name'] as $i => $name) {
                $order = $_POST['target_order'][$i];
                $init_conc = $_POST['initial_concentration'][$i];
                $stmt->bind_param("isdi", $order, $name, $init_conc, $project_id);
                $stmt->execute();
            }
            $stmt->close();
        }

        $conn->commit();
        header("Location: test_code_add_data.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}

// Add Analysis (Chemicals and Treatments)
if (isset($_POST['add_analysis'])) {
    $conn->begin_transaction();
    try {
        $project_id = $_POST['project_id'];
        $test_number = $_POST['test_number'];

        // Insert chemicals
        if (!empty($_POST['chemical_name'])) {
            $stmt = $conn->prepare("INSERT INTO chemical_data (test_number, added_order, chemical_name, ml, ph, trpm, project_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
            foreach ($_POST['chemical_name'] as $i => $name) {
                $order = $_POST['add_order'][$i];
                $ml = $_POST['ml'][$i];
                $ph = $_POST['ph'][$i];
                $trpm = $_POST['trmp'][$i];
                $stmt->bind_param("iisddsi", $test_number, $order, $name, $ml, $ph, $trpm, $project_id);
                $stmt->execute();
            }
            $stmt->close();
        }

        // Insert treatments
        if (!empty($_POST['target_id'])) {
            $stmt = $conn->prepare("INSERT INTO treatment_data (target_id, test_number, target_achieved, concentration, reduction) VALUES (?, ?, ?, ?, ?)");
            foreach ($_POST['target_id'] as $i => $target_id) {
                $achieved = $_POST['target_achieved'][$i];
                $conc = $_POST['concentration'][$i];
                $reduction = $_POST['reduction'][$i];
                $stmt->bind_param("iisdd", $target_id, $test_number, $achieved, $conc, $reduction);
                $stmt->execute();
            }
            $stmt->close();
        }

        $conn->commit();
        header("Location: test_code_add_data.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>
