<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Overview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            //font-size: 12px;
        }
        .container {
            max-width: 100%;
            margin: auto;
        }
        .table {
            font-size: 12px;
        }
        .table thead th {
            color: white;
            text-align: center;
        }
        th a {
            color: white;
            text-decoration: none;
        }
        th a:hover {
            text-decoration: underline;
        }
        .no-wrap {
            white-space: nowrap;
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

                <!-- Card Header with Search -->
                <div class="card-header">
                    <h5 class="mb-0">📂 Projects</h5>

                    <nav class="navbar bg-body-tertiary bg-secondary-subtle">
                        <form class="container-fluid" method="GET" action="test_code.php">
                            <div class="input-group mb-2">
                                <input type="text" name="customer_name" class="form-control" placeholder="Customer Name" value="<?= $_GET['customer_name'] ?? '' ?>">
                                <input type="text" name="company_name" class="form-control" placeholder="Company Name" value="<?= $_GET['company_name'] ?? '' ?>">
                                <input type="text" name="project_name" class="form-control" placeholder="Project Name" value="<?= $_GET['project_name'] ?? '' ?>">
                                <input type="text" name="sector" class="form-control" placeholder="Sector" value="<?= $_GET['sector'] ?? '' ?>">
                                <input type="text" name="target_name" class="form-control" placeholder="Target Name" value="<?= $_GET['target_name'] ?? '' ?>">
                            </div>

                            <div class="btn-group" role="group" aria-label="Search buttons">
                                <button type="submit" class="btn btn-outline-primary">🔍 Search</button>
                                <a href="index.php" class="btn btn-outline-primary">🔄 Reset</a>
                            </div>
                        </form>
                    </nav>
                </div>

                <!-- Table Body -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-dark table-hover">
                            <thead>
                                <tr>
                                    <th class="no-wrap">
                                        <a href="?sort=customer_name&order=<?= ($_GET['order'] ?? 'asc') === 'asc' ? 'desc' : 'asc' ?>">Customer</a>
                                    </th>
                                    <th class="no-wrap">
                                        <a href="?sort=company_name&order=<?= ($_GET['order'] ?? 'asc') === 'asc' ? 'desc' : 'asc' ?>">Company</a>
                                    </th>
                                    <th class="no-wrap">
                                        <a href="?sort=project_name&order=<?= ($_GET['order'] ?? 'asc') === 'asc' ? 'desc' : 'asc' ?>">Project</a>
                                    </th>
                                    <th class="no-wrap">
                                        <a href="?sort=sector&order=<?= ($_GET['order'] ?? 'asc') === 'asc' ? 'desc' : 'asc' ?>">Sector</a>
                                    </th>

                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <th class="no-wrap">Target <?= $i ?></th>
                                        <th class="no-wrap">Initial Concentration <?= $i ?></th>
                                    <?php endfor; ?>
                                </tr>
                            </thead>
                            <tbody id="projects-table-body">
                                <!-- Dynamic rows will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fetch and populate the project table
        function fetchProjects() {
            const params = new URLSearchParams(window.location.search);
            fetch('api/fetch_projects_summary.php?' + params.toString())
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

                    // Make rows clickable
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
