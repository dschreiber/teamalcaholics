<?php

global $pdo;

$sql = $pdo->prepare("SELECT * FROM event WHERE event_id = ?");
$event_id = $_REQUEST['event_id'];
$sql->execute([$event_id]);
$event = $sql->fetch();
