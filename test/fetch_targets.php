<?php
include 'test_code_add_data_db_connection.php';

if (isset($_POST['project_id'])) {
    $project_id = $_POST['project_id'];

    // Fetch targets for the selected project
    $stmt = $conn->prepare("SELECT ID, target_name FROM target_data WHERE project_id = ?");
    $stmt->bind_param("i", $project_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<h5>Project Targets</h5>';
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
				</div>
            ';
        }
    } else {
        echo '<p>No targets found for this project.</p>';
    }

    $stmt->close();
}

$conn->close();
?>

