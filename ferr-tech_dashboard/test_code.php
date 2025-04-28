<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Overview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-size: 12px; }
        .container { max-width: 100%; margin: auto; }
        .table-container { font-size: 12px; }
        .table thead th { color: white; text-align: center; }
        th a { color: white; text-decoration: none; }
        th a:hover { text-decoration: underline; }
        .no-wrap { white-space: nowrap; }
    </style>
</head>
<body class="bg-secondary">

<div class="container mt-5">
    <div class="card bg-secondary-subtle">
        <div class="card-header">
            <h5 class="mb-0">📂 Projects</h5>

            <!-- Search Form -->
            <nav class="navbar bg-body-tertiary bg-secondary-subtle">
                <form class="container-fluid" method="GET" action="test_code.php">
                    <div class="input-group" style="padding-bottom: 10px;">
                        <input type="text" name="customer_name" class="form-control" placeholder="Customer Name" value="<?= $_GET['customer_name'] ?? '' ?>">
                        <input type="text" name="company_name" class="form-control" placeholder="Company Name" value="<?= $_GET['company_name'] ?? '' ?>">
                        <input type="text" name="project_name" class="form-control" placeholder="Project Name" value="<?= $_GET['project_name'] ?? '' ?>">
                        <input type="text" name="sector" class="form-control" placeholder="Sector" value="<?= $_GET['sector'] ?? '' ?>">
                        <input type="text" name="target_name" class="form-control" placeholder="Target Name" value="<?= $_GET['target_name'] ?? '' ?>">
                    </div>
                    <div class="btn-group" role="group" aria-label="Search buttons">
                        <button type="submit" class="btn btn-dark">🔍 Search</button>
                        <a href="test_code.php" class="btn btn-dark">🔄 Reset</a>
                        <a href="test_code_add_data.php" class="btn btn-dark">➕ Add Data</a>
                    </div>
                </form>
            </nav>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-dark table-hover">
                    <thead>
                        <tr>
                            <th class="no-wrap"><a href="?sort=customer_name&order=<?= ($_GET['order'] ?? 'asc') === 'asc' ? 'desc' : 'asc' ?>">Customer</a></th>
                            <th class="no-wrap"><a href="?sort=company_name&order=<?= ($_GET['order'] ?? 'asc') === 'asc' ? 'desc' : 'asc' ?>">Company</a></th>
                            <th class="no-wrap"><a href="?sort=project_name&order=<?= ($_GET['order'] ?? 'asc') === 'asc' ? 'desc' : 'asc' ?>">Project</a></th>
                            <th class="no-wrap"><a href="?sort=sector&order=<?= ($_GET['order'] ?? 'asc') === 'asc' ? 'desc' : 'asc' ?>">Sector</a></th>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <th class="no-wrap">Target <?= $i ?></th>
                                <th class="no-wrap">Initial Concentration <?= $i ?></th>
                            <?php endfor; ?>
                        </tr>
                    </thead>
                    <tbody id="projects-table-body">
                        <!-- Data will be inserted here via JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function fetchProjects() {
    const params = new URLSearchParams(window.location.search);
    fetch('/ferr-tech_dashboard/api/fetch_projects_summary.php?' + params.toString())
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('projects-table-body');
            tbody.innerHTML = '';

            data.forEach(row => {
                const tr = document.createElement('tr');
                tr.className = 'clickable-row';
                tr.dataset.href = `project_details.php?project_id=${row.ID}`;

                const targets = row.targets?.split('|') || [];
                const initials = row.initial_concentrations?.split('|') || [];

                tr.innerHTML += `<td class="text-capitalize">${row.customer_name}</td>`;
                tr.innerHTML += `<td class="text-capitalize">${row.company_name}</td>`;
                tr.innerHTML += `<td class="text-capitalize">${row.project_name}</td>`;
                tr.innerHTML += `<td class="text-capitalize">${row.sector}</td>`;

                for (let i = 0; i < 5; i++) {
                    tr.innerHTML += `<td class="text-capitalize">${targets[i] || ''}</td>`;
                    tr.innerHTML += `<td class="text-capitalize">${initials[i] || ''}</td>`;
                }

                tbody.appendChild(tr);
            });

            document.querySelectorAll(".clickable-row").forEach(row => {
                row.style.cursor = "pointer";
                row.addEventListener("click", () => {
                    window.location.href = row.dataset.href;
                });
            });
        });
}

document.addEventListener('DOMContentLoaded', fetchProjects);
</script>
</body>
</html>
