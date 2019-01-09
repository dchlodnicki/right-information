<?php

use Model\Model;

require_once '../run.php';

if(isset($_POST['name'], $_POST['address'], $_POST['date'], $_POST['time'], $_POST['color'], $_POST['website'])) {
    
    $name = htmlspecialchars(strip_tags($_POST['name']));
    $address = htmlspecialchars(strip_tags($_POST['address']));
    $date = htmlspecialchars(strip_tags($_POST['date']));
    $time = htmlspecialchars(strip_tags($_POST['time']));
    $color = htmlspecialchars(strip_tags($_POST['color']));
    $website = htmlspecialchars(strip_tags($_POST['website']));
    
    $data = [
        'name' => $name,
        'address' => $address,
        'date' => $date,
        'time' => $time,
        'color' => $color,
        'website' => $website
    ];
    
    $model = new Model();
    $model->getConnection();
    $model->addPerson($data);
}

header('Location: /')

