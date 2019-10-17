<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
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

$db_class->parent_id = $data->parent_id;
$db_class->name = $data->name;
$db_class->sort_order = $data->sort_order;

// Create post
if ($db_class->create()) {
    echo json_encode(
        array('message', 'Record Created')
    );
} else {
    echo json_encode(
        array('message', 'Record Not Created')
    ); 
}