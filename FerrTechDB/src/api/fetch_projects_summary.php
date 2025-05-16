<?php
include 'project_detail_db_connection.php';

$filters = [];
$params = [];

// Add filters dynamically
if (!empty($_GET['customer_name'])) {
    $filters[] = "cd.customer_name LIKE ?";
    $params[] = "%" . $_GET['customer_name'] . "%";
}
if (!empty($_GET['company_name'])) {
    $filters[] = "cd.company_name LIKE ?";
    $params[] = "%" . $_GET['company_name'] . "%";
}
if (!empty($_GET['project_name'])) {
    $filters[] = "pd.project_name LIKE ?";
    $params[] = "%" . $_GET['project_name'] . "%";
}
if (!empty($_GET['sector'])) {
    $filters[] = "pd.sector LIKE ?";
    $params[] = "%" . $_GET['sector'] . "%";
}
if (!empty($_GET['target_name'])) {
    $filters[] = "td.target_name LIKE ?";
    $params[] = "%" . $_GET['target_name'] . "%";
}

$filterSql = $filters ? 'WHERE ' . implode(' AND ', $filters) : '';

// Sorting
$sort = $_GET['sort'] ?? 'pd.project_name';
$order = ($_GET['order'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';

$sql = "
    SELECT 
        pd.ID,
        cd.customer_name,
        cd.company_name,
        pd.project_name,
        pd.sector,
        GROUP_CONCAT(td.target_name ORDER BY td.target_order SEPARATOR '|') AS targets,
        GROUP_CONCAT(td.initial_concentration ORDER BY td.target_order SEPARATOR '|') AS initial_concentrations
    FROM project_data pd
    JOIN customer_data cd ON pd.customer_id = cd.ID
    LEFT JOIN target_data td ON td.project_id = pd.ID
    $filterSql
    GROUP BY pd.ID
    ORDER BY $sort $order
";

$stmt = $conn->prepare($sql);
if ($params) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>
