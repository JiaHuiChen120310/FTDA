<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <title>COD Prediction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <h5 class="mb-0">Predict COD Value</h5>
                </div>
                <div class="card-body">
                    <form id="predict-form">
                        <div class="mb-3">
                            <label for="Sector" class="form-label">Sector</label>
							<select class="form-select" id="Sector" name="Sector">
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
                            <label for="cod_before" class="form-label">Current COD</label>
                            <input type="number" step="0.01" class="form-control" id="cod_before" name="cod_before" required>
                        </div>

                        <!-- Chemical Inputs -->
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <label for="chem<?= $i ?>" class="form-label">Chemical <?= $i ?></label>
                                    </div>
                                    <div class="col">
                                        <label for="chem<?= $i ?>_dose" class="form-label">Chemical <?= $i ?> dose</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
										<select class="form-select" id="chem<?= $i ?>_name" name="chem<?= $i ?>_name">
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
                                        <input type="number" step="0.01" class="form-control" id="chem<?= $i ?>_dose" name="chem<?= $i ?>_dose">
                                    </div>
                                </div>
                            </div>
                        <?php endfor; ?>
                        <!-- End chemical inputs -->

                        <button type="submit" class="btn btn-outline-primary w-100">Predict</button>
                    </form>
                </div>

                <div id="result" class="mt-4 text-center"></div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('predict-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const data = {
                Sector: document.getElementById('Sector').value,
                cod_before: parseFloat(document.getElementById('cod_before').value),
                chem1: document.getElementById('chem1_name').value,
                chem1_dose: parseFloat(document.getElementById('chem1_dose').value),
                chem2: document.getElementById('chem2_name').value,
                chem2_dose: parseFloat(document.getElementById('chem2_dose').value),
                chem3: document.getElementById('chem3_name').value,
                chem3_dose: parseFloat(document.getElementById('chem3_dose').value),
                chem4: document.getElementById('chem4_name').value,
                chem4_dose: parseFloat(document.getElementById('chem4_dose').value),
                chem5: document.getElementById('chem5_name').value,
                chem5_dose: parseFloat(document.getElementById('chem5_dose').value),
                chem6: document.getElementById('chem6_name').value,
                chem6_dose: parseFloat(document.getElementById('chem6_dose').value),
                chem7: document.getElementById('chem7_name').value,
                chem7_dose: parseFloat(document.getElementById('chem7_dose').value),
                chem8: document.getElementById('chem8_name').value,
                chem8_dose: parseFloat(document.getElementById('chem8_dose').value),
                chem9: document.getElementById('chem9_name').value,
                chem9_dose: parseFloat(document.getElementById('chem9_dose').value),
                chem10: document.getElementById('chem10_name').value,
                chem10_dose: parseFloat(document.getElementById('chem10_dose').value)
            };

            fetch('api/predict_cod.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(data => {
                const resDiv = document.getElementById('result');
                if (data.success) {
                    resDiv.innerHTML = `<h4 class="text-success">Predicted COD: ${data.prediction.toFixed(2)}</h4>`;
                } else {
                    resDiv.innerHTML = `<h4 class="text-danger">Error: ${data.error}</h4>`;
                }
            });
        });
    </script>
</body>

</html>
