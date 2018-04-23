<?php

global $pdo;

$sql = $pdo->prepare("SELECT * FROM event WHERE event_type = 1 and event_end >= ? ORDER BY event_start");
$today = date('m/d/Y');
$sql->execute([$today]);

$events = $sql->fetchAll();
