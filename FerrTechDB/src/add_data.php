<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            //background-color: #f8f9fa;
        }

        .container {
            //max-width: 900px;
            //background: white;
            padding: 20px;
            //border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-weight: bold;
            //margin-bottom: 20px;
            //color: #343a40;
        }

        .nav-tabs .nav-link {
            font-weight: bold;
            color: #495057;
        }

        .nav-tabs .nav-link.active {
            //background-color: #007bff;
            //color: white;
        }
    </style>
</head>

<body>
    <div class="d-flex" style="min-height: 100vh;">

        <!-- Sidebar -->
        <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4">Ferr Tech</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="index.php" class="nav-link text-white" aria-current="page">Home</a>
                </li>
                <li>
                    <a href="add_data.php" class="nav-link text-white">Add Data</a>
                </li>
                <li>
                    <a href="predict_cod_ui.php" class="nav-link text-white">COD Prediction</a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
			<div class="card bg-secondary-subtle">
				<div class="card-header">
					<h5 class="mb-0">Add Data</h5>
				</div>

				<div class="card-body">
					<div class="btn-group" role="group" aria-label="Search buttons"></div>

					<!-- Tab Navigation -->
					<ul class="nav nav-tabs" id="dataTabs" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link active" id="customer-tab" data-bs-toggle="tab" data-bs-target="#customer" type="button" role="tab">Add Customer</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="project-tab" data-bs-toggle="tab" data-bs-target="#project" type="button" role="tab">Add Project</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="analysis-tab" data-bs-toggle="tab" data-bs-target="#analysis" type="button" role="tab">Add Analysis</button>
						</li>
					</ul>

					<div class="tab-content mt-3">

						<!-- Customer Tab -->
						<div class="tab-pane fade show active" id="customer" role="tabpanel">
							<form id="customerForm">
								<div class="mb-3">
									<label class="form-label">Customer Name</label>
									<input type="text" name="customer_name" class="form-control" required>
								</div>

								<div class="mb-3">
									<label class="form-label">Company Name</label>
									<input type="text" name="company_name" class="form-control" required>
								</div>

								<div class="mb-3">
									<label class="form-label">Address</label>
									<input type="text" name="address" class="form-control">
								</div>

								<div class="row g-3">
									<div class="col">
										<label class="form-label">Email</label>
										<input type="email" name="email" class="form-control">
									</div>
									<div class="col">
										<label class="form-label">Phone</label>
										<input type="text" name="phone" class="form-control">
									</div>
								</div>
								<button type="submit" class="btn btn-outline-primary" style="margin-top: 20px;" id="customerButton">Add Customer</button>
							</form>
						</div>

						<!-- Project Tab -->
						<div class="tab-pane fade" id="project" role="tabpanel">
							<form id="projectForm">
								<div class="mb-3">
									<label class="form-label">Project Name</label>
									<input type="text" name="project_name" class="form-control" required>
								</div>

								<div class="mb-3">
									<label class="form-label">Sector</label>
									<select class="form-select" id="sector" name="sector">
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

								<div class="mb-3">
									<label class="form-label">Customer</label>
									<select name="customer_id" class="form-select" required>
										<option value="">Loading...</option>
									</select>
								</div>

								<div class="mb-3">
									<label class="form-label">Number of Targets</label>
									<select id="numTargets" class="form-select">
										<option value="">Select</option>
										<?php for ($i = 1; $i <= 5; $i++): ?>
											<option value="<?= $i ?>"><?= $i ?></option>
										<?php endfor; ?>
									</select>
								</div>

								<div id="targetFields"></div>

								<button type="submit" class="btn btn-outline-primary" id="projectButton">Add Project</button>
							</form>
						</div>

						<!-- Analysis Tab -->
						<div class="tab-pane fade" id="analysis" role="tabpanel">
							<form id="analysisForm">
								<div class="mb-3">
									<label class="form-label">Select Project</label>
									<select id="selectProject" name="project_id" class="form-select" required>
										<option value="">Loading...</option>
									</select>
								</div>

								<div class="mb-3">
									<label class="form-label">Test Number</label>
									<input type="text" name="test_number" class="form-control" required>
								</div>

								<div class="mb-3">
									<label class="form-label">Number of Chemicals</label>
									<select id="numChemicals" class="form-select">
										<option value="">Select</option>
										<?php for ($i = 1; $i <= 10; $i++): ?>
											<option value="<?= $i ?>"><?= $i ?></option>
										<?php endfor; ?>
									</select>
								</div>

								<div id="chemicalFields"></div>

								<h5 class="mt-3">Target Results</h5>
								<div id="targetFieldsAnalysis"></div>

								<button type="submit" class="btn btn-outline-primary">Add Analysis</button>
							</form>
						</div>

					</div>
				</div>
			</div>
		</div>
    </div>

    <!-- Scripts -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script>
		function serializeForm(form) {
			const formData = new FormData(form);
			const data = {};

			for (let [key, value] of formData.entries()) {
				if (key.endsWith('[]')) {
					const cleanKey = key.replace('[]', '');
					if (!data[cleanKey]) data[cleanKey] = [];
					data[cleanKey].push(value);
				} else {
					data[key] = value;
				}
			}

			return data;
		}

		async function submitForm(url, formId, shouldReload = false) {
			const form = document.getElementById(formId);
			const data = serializeForm(form);

			try {
				const response = await fetch(url, {
					method: 'POST',
					headers: { 'Content-Type': 'application/json' },
					body: JSON.stringify(data),
				});

				const text = await response.text();
				console.log("Raw response from server:", text);

				const json = JSON.parse(text);
				if (!json.success) throw new Error(json.message);
				//alert("Success: " + json.message);
				form.reset();
				if (shouldReload) {
					location.reload();
				}
			} catch (err) {
				console.error("Error parsing JSON:", err);
				alert("Error: Could not parse server response. Check console.");
			}
		}

		$(document).ready(function () {
			// Display target fields when number of targets is selected
			$("#numTargets").change(function () {
				let num = $(this).val();
				$("#targetFields").html('');

				for (let i = 1; i <= num; i++) {
					$("#targetFields").append(`
						<div class="row" style="padding-bottom: 10px;">
							<div class="col">
								<label>Target ${i} Name</label>
								<input type="text" name="target_name[]" class="form-control" required>
							</div>
							<div class="col">
								<label>Initial Concentration</label>
								<input type="number" step="0.01" name="initial_concentration[]" class="form-control">
							</div>
							<input type="hidden" name="target_order[]" value="${i}">
						</div>
					`);
				}
			});

			// Display project targets when a project is selected
			$("#selectProject").change(function () {
				let projectId = $(this).val();

				if (projectId) {
					$.ajax({
						url: 'api/fetch_targets.php',
						type: 'POST',
						data: { project_id: projectId },
						success: function (response) {
							$("#targetFieldsAnalysis").html(response);
						}
					});
				} else {
					$("#targetFieldsAnalysis").html('');
				}
			});

			// Display chemical fields when number of chemicals is selected
			$("#numChemicals").change(function () {
				let num = $(this).val();
				$("#chemicalFields").html('');

				for (let i = 1; i <= num; i++) {
					$("#chemicalFields").append(`
						<div class="row" style="padding-bottom: 10px;">
							<div class="col">
								<label>Chemical ${i} Name</label>
								<select class="form-select" name="chemical_name[]">
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
							<div class="col">
								<label>mL</label>
								<input type="number" step="0.01" name="ml[]" class="form-control">
							</div>
							<div class="col">
								<label>PH</label>
								<input type="number" step="0.01" name="ph[]" class="form-control">
							</div>
							<div class="col">
								<label>Time x RPM (trmp)</label>
								<input type="text" name="trpm[]" class="form-control">
							</div>
							<input type="hidden" name="add_order[]" value="${i}">
						</div>
					`);
				}
			});

			// Fetch customers when Project tab is opened
			$.ajax({
				url: 'api/fetch_customers.php',
				type: 'GET',
				dataType: 'json',
				success: function (response) {
					console.log('Response from fetch_customers.php:', response);

					if (response && Array.isArray(response)) {
						let customerOptions = '<option value="">Select Customer</option>';
						response.forEach(customer => {
							customerOptions += `<option value="${customer.id}">${customer.name}</option>`;
						});
						$("select[name='customer_id']").html(customerOptions);
					} else {
						console.error('Expected JSON array, but got:', response);
					}
				},
				error: function (xhr, status, error) {
					console.error('AJAX error:', error);
				}
			});

			// Fetch projects when Analysis tab is opened
			$.ajax({
				url: 'api/fetch_projects.php',
				type: 'GET',
				dataType: 'json',
				success: function (response) {
					console.log('Response from fetch_projects.php:', response);

					if (response && Array.isArray(response)) {
						let projectOptions = '<option value="">Select Project</option>';
						response.forEach(project => {
							projectOptions += `<option value="${project.id}">${project.name}</option>`;
						});
						$("select[name='project_id']").html(projectOptions);
					} else {
						console.error('Expected JSON array, but got:', response);
					}
				},
				error: function (xhr, status, error) {
					console.error('AJAX error:', error);
				}
			});

			// Form submission handlers
			document.getElementById("customerForm").addEventListener("submit", function (e) {
				e.preventDefault();
				submitForm("api/add_customer.php", "customerForm", true);
			});

			document.getElementById("projectForm").addEventListener("submit", function (e) {
				e.preventDefault();
				submitForm("api/add_project.php", "projectForm", true);
			});

			document.getElementById("analysisForm").addEventListener("submit", function (e) {
				e.preventDefault();
				submitForm("api/add_analysis.php", "analysisForm", false);
			});
		});
		

	</script>
</body>
</html>
