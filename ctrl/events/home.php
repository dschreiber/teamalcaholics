<?php

global $pdo;

$sql = $pdo->prepare("SELECT * FROM events WHERE date >= ?");
$today = date('m/d/Y');
$sql->execute([$today]);
$events = $sql->fetch();

