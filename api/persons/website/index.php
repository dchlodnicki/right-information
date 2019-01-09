<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

use Config\Database;
use Objects\Website;

require_once '../../../src/run.php';
 
$database = new Database();
$db = $database->getConnection();

$website = new Website($db);
    
$stmt = $website->read();
$num = $stmt->rowCount();
 
if($num > 0){
 
    $website_arr = array();
    $website_arr['records']=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);
 
        $website_item = array(
            'name' => $name
        );
 
        array_push($website_arr['records'], $website_item);
    }
 
    http_response_code(200);
 
    echo json_encode($website_arr);
}
else {
    
    http_response_code(404);
 
    echo json_encode(
        array('message' => 'No website found.')
    );
}

