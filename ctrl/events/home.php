<?php

global $pdo;

$sql = $pdo->prepare("SELECT * FROM event WHERE date >= ?");
$today = date('m/d/Y');
$sql->execute([$today]);
$events = $sql->fetch();

