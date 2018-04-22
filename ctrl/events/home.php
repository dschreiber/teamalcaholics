<?php

global $pdo;

$sql = $pdo->prepare("SELECT * FROM event WHERE event_end >= ?");
$today = date('m/d/Y');
$sql->execute([$today]);
$events = $sql->fetch();

