<?php
include 'add_data_db_connection.php';

if (isset($_POST['project_id'])) {
    $project_id = $_POST['project_id'];
    $sql = "SELECT * FROM target_data WHERE project_id = $project_id ORDER BY target_order ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '
			<div style="padding-bottom: 10px;">
					<div style="padding-bottom: 5px;">
						<div class="row g-3">
							<label>Target: ' . htmlspecialchars($row['target_name']) . '</label>
							<input type="hidden" name="target_id[]" value="' . $row['ID'] . '">
							<div class="col"><label>Target Achieved</label>
							<select  class="form-select" aria-label="Default select example" name="target_achieved[]">
								<option value=""></option>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>
							</div>
							<div class="col"><label>Concentration</label><input type="number" step="0.01" name="concentration[]" class="form-control"></div>
							<div class="col"><label>Reduction</label><input type="number" step="0.01" name="reduction[]" class="form-control"></div>
						</div>
					</div>
				</div>';
        }
    } else {
        echo '<p>No targets found for this project.</p>';
    }
}

$conn->close();
?>
