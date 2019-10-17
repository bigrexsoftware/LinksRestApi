<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Link.php';

// Instantiate DB
$database = new Database();
$db = $database->connect();

// Instantiate object
$db_class = new Link($db);

// Get ID
$db_class->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get record
$db_class->read_by_id();

// Create array
$record_array = array(
    'id' => $db_class->id,
    'category_id' => $db_class->category_id,
    'sort_order' => $db_class->sort_order,
    'url' => $db_class->url,
    'title' => $db_class->title,
    'source' => $db_class->source,
    'author' => $db_class->author,
    'target' => $db_class->target
);

// Make JSON
print_r(json_encode($record_array));


