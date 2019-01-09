<?php

$sort_by = htmlspecialchars(strip_tags($_POST['sort_by']));
$born_from = htmlspecialchars(strip_tags($_POST['born_from']));
$born_to = htmlspecialchars(strip_tags($_POST['born_to']));
$with_color = $_POST['with_color'] ?? 'off';
$with_color = htmlspecialchars(strip_tags($with_color));
$with_website = $_POST['with_website'] ?? 'off';
$with_website = htmlspecialchars(strip_tags($with_website));

$http_data = array(
    'sort_by' => $sort_by,
    'born_from' => $born_from,
    'born_to' => $born_to,
    'with_color' => $with_color,
    'with_website' => $with_website
);

$http_data = http_build_query($http_data);

header('Location: /index.php?'.$http_data.'&number_page=1');

