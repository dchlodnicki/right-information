<?php

use Controller\PersonController;
require_once 'src/run.php';

$controller = new PersonController;
$controller->index();

