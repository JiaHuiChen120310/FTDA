<?php
$servername = "localhost";
$username = "root";
$password = "Ferr-Tech!120310";
$dbname = "testrun_2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Default sorting
$sort_column = $_GET['sort'] ?? 'customer_name';
$sort_order = ($_GET['order'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';

// Allowed columns for sorting (prevents SQL injection)
$allowed_columns = [
    'customer_name', 'company_name', 'target_name', 'expected_initial_concentration',
    'initial_concentration', 'test_number', 'chemical_name', 'ph', 'time_rpm',
    'target_achieved', 'concentration_mg_l', 'reduction'
];

if (!in_array($sort_column, $allowed_columns)) {
    $sort_column = 'customer_name';
}

// Filtering conditions
$conditions = [];
$params = [];
$search_fields = ['customer_name', 'company_name', 'target_name', 'chemical_name', 'ph', 'target_achieved','test_number','ml'];

foreach ($search_fields as $field) {
    if (!empty($_GET[$field])) {
        $conditions[] = "$field LIKE ?";
        $params[] = "%{$_GET[$field]}%";
    }
}

// Construct SQL query dynamically
$sql = "
    SELECT c.customer_name, c.company_name, p.target_name, p.project_name,
           p.expected_initial_concentration, p.initial_concentration, p.max_concentration,
           a.test_number, a.chemical_name, a.ph, a.time_rpm, a.ml,
           a.target_achieved, a.concentration_mg_l, a.reduction
    FROM projects p
    INNER JOIN customer_data c ON p.customer_id = c.customer_id
    LEFT JOIN analysis a ON p.project_id = a.project_id";

// Append filtering conditions
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// Apply sorting
$sql .= " ORDER BY $sort_column $sort_order";

// Prepare and execute query
$stmt = $conn->prepare($sql);
if ($stmt && !empty($params)) {
    $stmt->bind_param(str_repeat("s", count($params)), ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>
