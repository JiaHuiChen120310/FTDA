<?php
if (!isset($_GET['project_id'])) {
    die("Project ID not provided.");
}
$project_id = intval($_GET['project_id']);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <title>Project Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container { overflow-x: auto; }
        .table { font-size: 12px; background-color: lightblue; }
        th { white-space: nowrap; }
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
                    <h5 class="mb-0">Project Details</h5>
                </div>
                <div class="card-body">
                    <div class="overflow-x-auto">
                        <table class="table table-striped table-bordered table-dark table-hover" id="details-table">
                            <thead id="table-head"></thead>
                            <tbody id="table-body"></tbody>
                        </table>
                    </div>
                </div>
                <div id="result" class="mt-4 text-center"></div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const projectId = <?= $project_id ?>;

        function createCell(content = '', isHeader = false, extraClass = '') {
            const cell = document.createElement(isHeader ? 'th' : 'td');
            cell.innerHTML = content;
            if (extraClass) cell.className = extraClass;
            return cell;
        }

        function addRow(label, testNumbers, dataByTest, accessor) {
            const row = document.createElement('tr');
            row.appendChild(createCell(label, true));
            testNumbers.forEach(test => {
                const value = accessor(dataByTest[test]);
                row.appendChild(createCell(value ?? ''));
            });
            return row;
        }

        function renderTable(testNumbers, chemicals, targets) {
            const thead = document.getElementById('table-head');
            const tbody = document.getElementById('table-body');
            thead.innerHTML = '';
            tbody.innerHTML = '';

            // Header Row
            const headerRow = document.createElement('tr');
            headerRow.appendChild(createCell('Label', true));
            testNumbers.forEach(test => {
                headerRow.appendChild(createCell(`Test ${test}`, true));
            });
            thead.appendChild(headerRow);

            // Chemicals (10 chemicals × 4 rows each)
            for (let i = 1; i <= 10; i++) {
                tbody.appendChild(addRow(`Chemical ${i} Name`, testNumbers, chemicals, t => t?.[i]?.chemical_name));
                tbody.appendChild(addRow(`ML`, testNumbers, chemicals, t => t?.[i]?.ml));
                tbody.appendChild(addRow(`PH`, testNumbers, chemicals, t => t?.[i]?.ph));
                tbody.appendChild(addRow(`Time x RPM`, testNumbers, chemicals, t => t?.[i]?.trpm));
            }

            // Targets (5 targets × 4 rows each)
            for (let j = 1; j <= 5; j++) {
                tbody.appendChild(addRow(`Target ${j} Name`, testNumbers, targets, t => t?.[j]?.target_name));
                tbody.appendChild(addRow(`Achieved`, testNumbers, targets, t => t?.[j]?.target_achieved));
                tbody.appendChild(addRow(`Concentration`, testNumbers, targets, t => t?.[j]?.concentration));
                tbody.appendChild(addRow(`Reduction`, testNumbers, targets, t => t?.[j]?.reduction));
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetch(`api/fetch_project_details.php?project_id=${projectId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        renderTable(data.test_numbers, data.chemicals, data.targets);
                    } else {
                        document.body.innerHTML = `<h3>Error: ${data.message}</h3>`;
                    }
                })
                .catch(err => {
                    document.body.innerHTML = `<h3>Fetch Error: ${err}</h3>`;
                });
        });
    </script>
</body>

</html>
