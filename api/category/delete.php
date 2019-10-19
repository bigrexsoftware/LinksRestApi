<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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

// Delete
if ($db_class->delete()) {
    echo json_encode(
        array('message', 'Record Deleted')
    );
} else {
    echo json_encode(
        array('message', 'Record Not Deleted')
    ); 
}