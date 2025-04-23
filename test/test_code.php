<?php include 'test_code_db_connection.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Overview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {font-size: 12px; }
        .container { max-width: 100%; margin: auto; }
        .table-container { font-size: 12px; }
        .table thead th {color: white; text-align: center; }
        th a { color: white; text-decoration: none; }
        th a:hover { text-decoration: underline; }
        .no-wrap { white-space: nowrap; }
    </style>
</head>
<body class="bg-secondary">

<div class="container mt-5 ">
    <div class="card bg-secondary-subtle">
        <div class="card-header">
            <h5 class="mb-0">📂 Projects</h5>
			<!-- Search Form -->
		<nav class="navbar bg-body-tertiary bg-secondary-subtle">
		  <form class="container-fluid" method="GET" action="test_code.php">
			<div class="input-group" style="padding-bottom: 10px;">
				<input type="text" name="customer_name" class="form-control" placeholder="Customer Name" value="<?php echo $_GET['customer_name'] ?? ''; ?>">
				<input type="text" name="company_name" class="form-control" placeholder="Company Name" value="<?php echo $_GET['company_name'] ?? ''; ?>">
				<input type="text" name="project_name" class="form-control" placeholder="Project Name" value="<?php echo $_GET['project_name'] ?? ''; ?>">
				<input type="text" name="sector" class="form-control" placeholder="Sector" value="<?php echo $_GET['sector'] ?? ''; ?>">
				<input type="text" name="target_name" class="form-control" placeholder="Target Name" value="<?php echo $_GET['target_name'] ?? ''; ?>">
			</div>
			<div  class="btn-group" role="group" aria-label="Basic outlined example">
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
                            <?php
                            $columns = [
                                'customer_name' => 'Customer',
                                'company_name' => 'Company',
                                'project_name' => 'Project',
                                'sector' => 'Sector'
                            ];
                            for ($i = 1; $i <= 5; $i++) {
                                $columns["target_$i"] = "Target $i";
                                $columns["initial_concentration_$i"] = "Initial Concentration $i";
                            }

                            foreach ($columns as $col => $name) {
                                $order = (isset($_GET['sort']) && $_GET['sort'] == $col && $_GET['order'] == 'asc') ? 'desc' : 'asc';
                                echo "<th class='no-wrap'><a href='?sort=$col&order=$order'>$name</a></th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
					<?php while ($row = $result->fetch_assoc()): ?>
						<?php 
							$targets = explode('|', $row['targets'] ?? '');
							$initials = explode('|', $row['initial_concentrations'] ?? '');
							$projectId = $row['ID']; // Capture project ID
						?>
						<tr class="clickable-row" data-href="project_details.php?project_id=<?= $projectId ?>">
							<td class="text-capitalize"><?php echo htmlspecialchars($row['customer_name']); ?></td>
							<td class="text-capitalize"><?php echo htmlspecialchars($row['company_name']); ?></td>
							<td class="text-capitalize"><?php echo htmlspecialchars($row['project_name']); ?></td>
							<td class="text-capitalize"><?php echo htmlspecialchars($row['sector']); ?></td>
							<?php for ($i = 0; $i < 5; $i++): ?>
								<td class="text-capitalize"><?php echo htmlspecialchars($targets[$i] ?? ''); ?></td>
								<td class="text-capitalize"><?php echo htmlspecialchars($initials[$i] ?? ''); ?></td>
							<?php endfor; ?>
						</tr>
					<?php endwhile; ?>
					</tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".clickable-row").forEach(row => {
            row.style.cursor = "pointer";
            row.addEventListener("click", () => {
                window.location.href = row.dataset.href;
            });
        });
    });
</script>
</body>
</html>

<?php $conn->close(); ?>