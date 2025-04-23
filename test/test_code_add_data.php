<?php 
include 'test_code_add_data_db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        .nav-tabs .nav-link.active {
            color: black;
        }
    </style>
</head>
<body class="bg-secondary">

<div class="container">
    <h5 class="mb-0">Add Data</h5>
	<div class="text-center mb-3">
        <a href="test_code.php" class="btn btn-dark">View Table</a>
	</div>
    <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#addCustomer">Add Customer</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#addProject">Add Project</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#addAnalysis">Add Analysis</a></li>
    </ul>

    <div class="tab-content mt-3">
        <!-- Add Customer Tab -->
        <div id="addCustomer" class="tab-pane fade show active">
            <h4>Add Customer</h4>
            <form method="POST" action="process_data.php">
				<div class="row g-3">
					<div class="col"><label>Customer Name</label><input type="text" name="customer_name" class="form-control" required></div>
					<div class="col"><label>Company Name</label><input type="text" name="company_name" class="form-control"></div>
				</div>
                <div class="mb-3"><label>Address</label><input type="text" name="address" class="form-control"></div>
				<div class="row g-3" style="padding-bottom: 10px;">
					<div class="col"><label>Email</label><input type="email" name="email" class="form-control"></div>
					<div class="col"><label>Phone</label><input type="text" name="phone" class="form-control"></div>
				</div>
                <button type="submit" name="add_customer" class="btn btn-dark w-100">Add Customer</button>
            </form>
        </div>

        <!-- Add Project Tab -->
        <div id="addProject" class="tab-pane fade">
            <h4>Add Project</h4>
            <form method="POST" action="process_data.php">
                <div class="mb-3"><label>Project Name</label><input type="text" name="project_name" class="form-control" required></div>
                <div class="mb-3"><label>Sector</label>
				<select  class="form-select" aria-label="Default select example" name="sector">
					<option value=""></option>
					<option value="Chemical">Chemical</option>
					<option value="Coating">Coating</option>
					<option value="Dairy">Dairy</option>
					<option value="Farming">Farming</option>
					<option value="Washing">Washing</option>
					<option value="Food processing">Food processing</option>
					<option value="Metal">Metal</option>
					<option value="Paper">Paper</option>
					<option value="PFAS">PFAS</option>
					<option value="Plastic">Plastic</option>
					<option value="RWZI">RWZI</option>
					<option value="Textile">Textile</option>
					<option value="Water treatment">Water treatment</option>
					<option value="Wastewater">Wastewater</option>
					<option value="Others">Others</option>
				</select>
				</div>
                <div class="mb-3"><label>Customer</label>
                    <select name="customer_id" class="form-control" required>
                        <option value="">Select Customer</option>
                        <?php
                        $customers = $conn->query("SELECT ID, customer_name FROM customer_data");
                        while ($row = $customers->fetch_assoc()) {
                            echo "<option value='{$row['ID']}'>{$row['customer_name']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Number of Targets Dropdown -->
                <div class="mb-3">
                    <label>Number of Targets</label>
                    <select id="numTargets" name="num_targets" class="form-control">
                        <?php for ($i = 0; $i <= 5; $i++) { echo "<option value='$i'>$i</option>"; } ?>
                    </select>
                </div>

                <!-- Dynamic Target Fields -->
                <div id="targetFields"></div>

                <button type="submit" name="add_project" class="btn btn-dark w-100">Add Project</button>
            </form>
        </div>

        <!-- Add Analysis Tab -->
        <div id="addAnalysis" class="tab-pane fade">
            <h4>Add Analysis</h4>
            <form method="POST" action="process_data.php">
				<div class="row g-3">
					<div class="col">
						<label>Project</label>
							<select id="selectProject" name="project_id" class="form-control" required>
								<option value="">Select Project</option>
								<?php
								$projects = $conn->query("SELECT ID, project_name FROM project_data");
								while ($row = $projects->fetch_assoc()) {
									echo "<option value='{$row['ID']}'>{$row['project_name']}</option>";
								}
								?>
							</select>
					</div>
					<div class="col"><label>Test Number</label><input type="Number" name="test_number" class="form-control" required></div>
				</div>
                <div class="mb-3"><label>Number of Chemicals</label>
                    <select id="numChemicals" class="form-control">
                        <?php for ($i = 0; $i <= 10; $i++) { echo "<option value='$i'>$i</option>"; } ?>
                    </select>
                </div>
                <div id="chemicalFields"></div>
                <div id="targetFieldsAnalysis"></div>
                <button type="submit" name="add_analysis" class="btn btn-dark w-100">Add Analysis</button>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $("#numTargets").change(function() {
        let num = $(this).val();
        $("#targetFields").html('');
        for (let i = 1; i <= num; i++) {
            $("#targetFields").append(`
			<div class="row" style="padding-bottom: 10px;">
                <div class="col"><label>Target ${i} Name</label><input type="text" name="target_name[]" class="form-control"></div>
                <div class="col"><label>Initial Concentration</label><input type="number" step="0.01" name="initial_concentration[]" class="form-control"></div>
                <input type="hidden" name="target_order[]" value="${i}">
			</div>
            `);
        }
    });

	$("#selectProject").change(function() {
        let projectId = $(this).val();
        if (projectId) {
            $.ajax({
                url: 'fetch_targets.php',
                type: 'POST',
                data: { project_id: projectId },
                success: function(response) {
                    $("#targetFieldsAnalysis").html(response);
                }
            });
        } else {
            $("#targetFieldsAnalysis").html('');
        }
    });



    $("#numChemicals").change(function() {
        let num = $(this).val();
        $("#chemicalFields").html('');
        for (let i = 1; i <= num; i++) {
            $("#chemicalFields").append(`
			<div class="row" style="padding-bottom: 10px;">
                <div class="col"><label>Chemical ${i} Name</label>
				<select  class="form-select" aria-label="Default select example" name="chemical_name[]">
					<option value=""></option>
					<option value="H2SO4">H2SO4</option>
					<option value="HClO">HClO</option>
					<option value="FeCl3">FeCl3</option>
					<option value="FerSol">FerSol</option>
					<option value="Poly">Poly</option>
					<option value="NaOH">NaOH</option>
					<option value="KFerSol">KFerSol</option>
					<option value="PAC">PAC</option>
					<option value="Iron Sulphate">Iron Sulphate</option>
					<option value="CaOH">CaOH</option>
					<option value="H2O2">H2O2</option>
					<option value="HNO3">HNO3</option>
					<option value="KH2PO4">KH2PO4</option>
					<option value="GAC">GAC</option>
					<option value="VTA/VAT">VTA/VAT</option>
					<option value="CTAB">CTAB</option>
					<option value="APG">APG</option>
					<option value="M40">M40</option>
					<option value="Al2(SO4)3/Al(SO4)3">Al2(SO4)3/Al(SO4)3</option>
					<option value="HCl">HCl</option>
					<option value="Fe2(SO4)3">Fe2(SO4)3</option>
					<option value="NaSi">NaSi</option>
					<option value="CH3COOH">CH3COOH</option>
					<option value="FeSO4">FeSO4</option>
					<option value="NaClO">NaClO</option>
					<option value="CaO">CaO</option>
					<option value="RP34">RP34</option>
					<option value="SDS">SDS</option>
					<option value="Na-EDTA">Na-EDTA</option>
					<option value="Combiphos L7">Combiphos L7</option>
					<option value="HB-5265">HB-5265</option>
				</select>
				</div>
                <div class="col"><label>mL</label><input type="number" step="0.01" name="ml[]" class="form-control"></div>
                <div class="col"><label>pH</label><input type="number" step="0.01" name="ph[]" class="form-control"></div>
                <div class="col"><label>Time x RPM (trmp)</label><input type="text" name="trmp[]" class="form-control"></div>
                <input type="hidden" name="add_order[]" value="${i}">
			</div>
            `);
        }
    });
});
</script>

</body>
</html>
