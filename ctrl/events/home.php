<?php

global $pdo;

$sql = $pdo->prepare("SELECT * FROM event WHERE event_end >= ? ORDER BY event_start");
$today = date('m/d/Y');
$sql->execute([$today]);

$events = $sql->fetchAll();