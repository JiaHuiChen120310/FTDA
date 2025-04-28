<?php
include 'add_data_db_connection.php';

if (isset($_POST['project_id'])) {
    $project_id = $_POST['project_id'];
    $sql = "SELECT * FROM target_data WHERE project_id = $project_id ORDER BY target_order ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '
            <div class="row" style="padding-bottom: 10px;">
                <div class="col"><label>' . htmlspecialchars($row['target_name']) . '</label></div>
                <div class="col"><label>Target Achieved</label><input type="text" class="form-control" name="target_achieved[]"></div>
                <div class="col"><label>Concentration</label><input type="number" step="0.01" class="form-control" name="concentration[]"></div>
                <div class="col"><label>Reduction</label><input type="number" step="0.01" class="form-control" name="reduction[]"></div>
            </div>';
        }
    } else {
        echo '<p>No targets found for this project.</p>';
    }
}

$conn->close();
?>
