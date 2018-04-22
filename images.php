<?php

include('db_init.php');

$pics= $pdo->prepare("SELECT * FROM event_pic WHERE event_id = ?");
$event_id = $_REQUEST['event_id'];
$pics->execute([$event_id]);

$pic = $pics->fetch();

header('Content-Type: ' . $pic['pic_content_type']);

echo $pic['pic'];

