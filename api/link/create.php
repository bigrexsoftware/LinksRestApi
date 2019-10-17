<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With ');

include_once '../../config/Database.php';
include_once '../../models/Link.php';

// Instantiate DB
$database = new Database();
$db = $database->connect();

// Instantiate object
$db_class = new Link($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$db_class->category_id = $data->category_id;
$db_class->sort_order = $data->sort_order;
$db_class->url = $data->url;
$db_class->title = $data->title;
$db_class->source = $data->source;
$db_class->author = $data->author;
$db_class->target = $data->target;

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