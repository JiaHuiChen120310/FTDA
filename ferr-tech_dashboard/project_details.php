<?php
// project_details.php
require_once 'config/db.php';

if (!isset($_GET['project_id'])) {
    die("Project ID not provided.");
}

$project_id = intval($_GET['project_id']);

// Fetch project details
$project
::contentReference[oaicite:0]{index=0}
 
