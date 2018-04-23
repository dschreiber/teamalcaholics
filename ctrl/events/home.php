<?php

global $pdo;

$sql = $pdo->prepare("SELECT * FROM event WHERE event_type = 1 and event_end >= ? ORDER BY event_start");
$today = date('m/d/Y');
$sql->execute([$today]);

$events = $sql->fetchAll();


$sql = $pdo->prepare("SELECT * FROM event_rsvp WHERE user_id = ?");
$sql->execute([$_SESSION['user_id']]);
$tmp = $sql->fetchAll();

$rsvps = array();
foreach ($tmp as $rsvp) {
    $rsvps[$rsvp['event_id']] = $rsvp['rsvp_status'];
}

