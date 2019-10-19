<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With ');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB
$database = new Database();
$db = $database->connect();

// Instantiate object
$db_class = new Category($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$db_class->id = $data->id;

$db_class->parent_id = $data->parent_id;
$db_class->name = $data->name;
$db_class->sort_order = $data->sort_order;

// Update
if ($db_class->update()) {
    echo json_encode(
        array('message', 'Record Updated')
    );
} else {
    echo json_encode(
        array('message', 'Record Not Updated')
    ); 
}