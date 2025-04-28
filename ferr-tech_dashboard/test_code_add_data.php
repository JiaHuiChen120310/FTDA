<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            //max-width: 900px;
            background: white;
            padding: 20px;
            //border-radius: 10px;
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
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">
<div class="container mt-4">
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
                <div class="mb-3"><label class="form-label">Customer Name</label><input type="text" name="customer_name" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Company Name</label><input type="text" name="company_name" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Address</label><input type="text" name="address" class="form-control"></div>
                <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control"></div>
                <div class="mb-3"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control"></div>
                <button type="submit" class="btn btn-primary">Add Customer</button>
            </form>
        </div>

        <!-- Project Tab -->
        <div class="tab-pane fade" id="project" role="tabpanel">
            <form id="projectForm">
                <div class="mb-3"><label class="form-label">Project Name</label><input type="text" name="project_name" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Sector</label><input type="text" name="sector" class="form-control"></div>
                <div class="mb-3"><label class="form-label">Customer</label>
                    <select name="customer_id" class="form-select" required>
                        <option value="">Loading...</option>
                    </select>
                </div>
                <div class="mb-3"><label class="form-label">Number of Targets</label>
                    <select id="numTargets" class="form-select">
                        <option value="">Select</option>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div id="targetFields"></div>
                <button type="submit" class="btn btn-success mt-2">Add Project</button>
            </form>
        </div>

        <!-- Analysis Tab -->
        <div class="tab-pane fade" id="analysis" role="tabpanel">
            <form id="analysisForm">
                <div class="mb-3"><label class="form-label">Select Project</label>
                    <select id="selectProject" name="project_id" class="form-select" required>
                        <option value="">Loading...</option>
                    </select>
                </div>
                <div class="mb-3"><label class="form-label">Test Number</label><input type="text" name="test_number" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Number of Chemicals</label>
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
                <button type="submit" class="btn btn-warning mt-2">Add Analysis</button>
            </form>
        </div>
    </div>
</div>

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

async function submitForm(url, formId) {
    const form = document.getElementById(formId);
    const data = serializeForm(form);

    const response = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });

        const result = await response.json();
    if (result.success) {
        //alert("Submission successful!");
        form.reset();

        // You don't need to change anything about the tab, so no need for extra code here.
        // Just reset the form fields and optionally clear other dynamic fields.
        if (formId === 'analysisForm') {
            $("#chemicalFields").html('');
            $("#targetFieldsAnalysis").html('');
        }
        if (formId === 'projectForm') {
            $("#targetFields").html('');
        }
    } else {
        alert("Submission failed." + JSON.stringify(result));
        console.error(result);
    }
}

$(document).ready(function() {
    $("#numTargets").change(function() {
        let num = $(this).val();
        $("#targetFields").html('');
        for (let i = 1; i <= num; i++) {
            $("#targetFields").append(`
                <div class="row" style="padding-bottom: 10px;">
                    <div class="col"><label>Target ${i} Name</label><input type="text" name="target_name[]" class="form-control" required></div>
                    <div class="col"><label>Initial Concentration</label><input type="number" step="0.01" name="initial_concentration[]" class="form-control" required></div>
                    <input type="hidden" name="target_order[]" value="${i}">
                </div>
            `);
        }
    });

    $("#selectProject").change(function() {
        let projectId = $(this).val();
        if (projectId) {
            $.ajax({
                url: 'api/fetch_targets.php',
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
                    <div class="col"><label>mL</label><input type="number" step="0.01" name="ml[]" class="form-control" required></div>
                    <div class="col"><label>pH</label><input type="number" step="0.01" name="ph[]" class="form-control" required></div>
                    <div class="col"><label>Time x RPM (trmp)</label><input type="text" name="trmp[]" class="form-control" required></div>
                    <input type="hidden" name="add_order[]" value="${i}">
                </div>
            `);
        }
    });
	
	// Dynamically fetch customers when the 'Project' tab is opened
    $.ajax({
    url: 'api/fetch_customers.php', // Correct path to your PHP file
    type: 'GET',
    dataType: 'json',  // Ensure that the response is expected to be JSON
    success: function(response) {
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
    error: function(xhr, status, error) {
        console.error('AJAX error:', error);
    }
});

    // Dynamically fetch projects when the 'Analysis' tab is opened
    $.ajax({
    url: 'api/fetch_projects.php',  // Correct path to your PHP file
    type: 'GET',
    dataType: 'json',  // Expecting a JSON response
    success: function(response) {
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
    error: function(xhr, status, error) {
        console.error('AJAX error:', error);
    }
});

    // Attach submit handlers
    document.getElementById("customerForm").addEventListener("submit", function(e) {
        e.preventDefault();
        submitForm("api/add_customer.php", "customerForm");
    });

    document.getElementById("projectForm").addEventListener("submit", function(e) {
        e.preventDefault();
        submitForm("api/add_project.php", "projectForm");
    });

    document.getElementById("analysisForm").addEventListener("submit", function(e) {
        e.preventDefault();
        submitForm("api/add_analysis.php", "analysisForm");
    });
});
</script>
</body>
</html>
