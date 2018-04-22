<?php

global $pdo;

$events = $pdo->prepare("SELECT * FROM event WHERE event_end >= ?");
$today = date('m/d/Y');
$events->execute([$today]);

