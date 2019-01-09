<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

use Config\Database;
use Objects\Person;

require_once '../../src/run.php';

$method = $_GET['action'];
$method = htmlspecialchars(strip_tags($method));
 
$database = new Database();
$db = $database->getConnection();

$person = new Person($db);

switch($method) {
    case 'GET':

        /* -------------------- GET -------------------- */
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $id = htmlspecialchars(strip_tags($id));
            $stmt = $person->read($id);
        }
        else {
            $stmt = $person->read(0);
        }

        $num = $stmt->rowCount();

        if($num > 0){

            $person_arr = array();
            $person_arr['records']=array();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                extract($row);

                $person_item = array(
                    'id' => $id,
                    'name' => $name,
                    'address' => $address,
                    'birth_date' => $birth_date,
                    'color' => $color,
                    'website' => $website,
                );

                array_push($person_arr['records'], $person_item);
            }

            http_response_code(200);

            echo json_encode($person_arr);
        }
        else {

            http_response_code(404);

            echo json_encode(
                array('message' => 'No persons found.')
            );
        }
    break;

    case 'PUT':

        /* -------------------- PUT -------------------- */
        $data = json_decode(file_get_contents('php://input'));

        $_GET['id'] = htmlspecialchars(strip_tags($_GET['id']));
        $person->id = $_GET['id'];

        $person->name = $data->name;
        $person->address = $data->address;
        $person->birth_date = $data->birth_date;
        $person->color = $data->color;
        $person->website = $data->website;

        if($person->update()) {

            http_response_code(200);

            echo json_encode(array('message' => 'Person was updated.'));
        }
        else {

            http_response_code(503);

            echo json_encode(array('message' => 'Unable to update person.'));
        }

    break;

    case 'DELETE':

        $person->id = $_GET['id'];

        if($person->delete()) {

            http_response_code(200);

            echo json_encode(array('message' => 'Person was deleted.'));
        }
        else {

            http_response_code(503);

            echo json_encode(array('message' => 'Unable to delete perosn.'));
        }

    break;
}

