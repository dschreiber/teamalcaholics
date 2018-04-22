<?php

include('db_init.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$url = 'http://i.pinimg.com/originals/3e/18/a5/3e18a50d5c985219626900e91d134fe3.jpg';

$data['event_id'] = 2;
$data['pic'] = file_get_contents($url);
$data['pic_content_type'] = 'image/jpeg';
$data['create_date'] = date('Y-m-d H:i:s');
$data['created_by'] = 1;

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $result = $pdo->prepare("INSERT INTO event_pic VALUES (NULL,:event_id,:pic,:pic_content_type,:create_date,:created_by)")->execute($data);
} catch (PDOException $e) {
    $existingkey = "Integrity constraint violation: 1062 Duplicate entry";
    if (strpos($e->getMessage(), $existingkey) !== FALSE) {

        // Take some action if there is a key constraint violation, i.e. duplicate name
    } else {
        throw $e;
    }
}

var_dump($result);
var_dump($pdo->errorCode());
