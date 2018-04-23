<?php

global $pdo;

$sql = $pdo->prepare("SELECT * FROM event WHERE event_id = ?");
$event_id = $_REQUEST['event_id'];
$sql->execute([$event_id]);
$event = $sql->fetch();

$sql = $pdo->prepare("SELECT * FROM event_rsvp WHERE user_id = ? and event_id = ?");
$sql->execute([$_SESSION['user_id'], $_REQUEST['event_id']]);
$tmp = $sql->fetch();

if ($tmp) {
    $rsvp = $tmp['rsvp_status'];
} else {
    $rsvp = false;
}

