<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB
$database = new Database();
$db = $database->connect();

// Instantiate object
$db_class = new Category($db);

// Query
$result = $db_class->read();

//Get row count
$num = $result->rowCount();

// Check if any records
if ($num > 0) {
    $records_arr = array();
    $records_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $item = array(
            'id' => $id,
            'parent_id' => $parent_id,
            'name' => html_entity_decode($name),
            'sort_order' => $sort_order
        );

        // Push to "data" array
        array_push($records_arr['data'], $item);      
    }

    // Turn to JSON and output
    echo json_encode($records_arr);

} else {
    echo json_encode(
        array('message' => 'No Records Found')
    );
}