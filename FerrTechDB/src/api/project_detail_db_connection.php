<?php
$servername = "mysql";
$username = "root";
$password = "Ferr-Tech!120310";
$dbname = "testrun_6";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Default sorting parameters
$sort_column = $_GET['sort'] ?? 'customer_name';
$sort_order = ($_GET['order'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';

// Allowed columns for sorting to prevent SQL injection
$allowed_columns = ['customer_name', 'company_name', 'project_name', 'sector'];
for ($i = 1; $i <= 5; $i++) {
    $allowed_columns[] = "target_$i";
    $allowed_columns[] = "initial_concentration_$i";
}

if (!in_array($sort_column, $allowed_columns)) {
    $sort_column = 'customer_name';
}

// Filtering parameters
$conditions = [];
$params = [];
$search_fields = ['customer_name', 'company_name', 'project_name', 'sector'];

foreach ($search_fields as $field) {
    if (!empty($_GET[$field])) {
        $conditions[] = "$field LIKE ?";
        $params[] = "%{$_GET[$field]}%";
    }
}

// Target filter handling
$projectFilter = "";
$projectIds = [];

if (!empty($_GET['target_name'])) {
    $target_search = "%{$_GET['target_name']}%";
    $stmt_proj = $conn->prepare("SELECT DISTINCT project_id FROM target_data WHERE target_name LIKE ?");
    $stmt_proj->bind_param("s", $target_search);
    $stmt_proj->execute();
    $res_proj = $stmt_proj->get_result();
    while ($row = $res_proj->fetch_assoc()) {
        $projectIds[] = $row['project_id'];
    }

    if (!empty($projectIds)) {
        $placeholders = implode(',', array_fill(0, count($projectIds), '?'));
        $projectFilter = "pd.ID IN ($placeholders)";
        foreach ($projectIds as $id) {
            $params[] = $id;
        }
    } else {
        $projectFilter = "0"; // No match forces no results
    }
}

// Build SQL query
$sql = "
    SELECT 
        pd.ID,
        cd.customer_name, 
        cd.company_name, 
        pd.project_name, 
        pd.sector,
        GROUP_CONCAT(td.target_name ORDER BY td.target_order ASC SEPARATOR '|') AS targets,
        GROUP_CONCAT(td.initial_concentration ORDER BY td.target_order ASC SEPARATOR '|') AS initial_concentrations
    FROM project_data pd
    JOIN customer_data cd ON pd.customer_id = cd.ID
    LEFT JOIN target_data td ON pd.ID = td.project_id
";

// Combine filtering conditions
$all_conditions = [];

if (!empty($conditions)) {
    $all_conditions = array_merge($all_conditions, $conditions);
}
if (!empty($projectFilter)) {
    $all_conditions[] = $projectFilter;
}

if (!empty($all_conditions)) {
    $sql .= " WHERE " . implode(" AND ", $all_conditions);
}

$sql .= " GROUP BY pd.ID, cd.ID ORDER BY $sort_column $sort_order";

// Prepare and execute the final statement
$stmt = $conn->prepare($sql);
if ($stmt) {
    $types = str_repeat("s", count($params));
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    die("Error preparing SQL statement: " . $conn->error);
}
?>
