<?php

use Model\Model;

require_once '../run.php';

if(isset($_GET['id'])) {
    
    $id = htmlspecialchars(strip_tags($_GET['id']));
    
    $model = new Model();
    $model->getConnection();
    $model->deletePerson($id);
}

header('Location: /');

