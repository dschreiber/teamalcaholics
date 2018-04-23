<?php

date_default_timezone_set('America/Los_Angeles');
session_start();

include ('db_init.php');

if (isset($_REQUEST['event_id']) && isset($_REQUEST['rsvp'])) {
    $rsvp['event_id'] = $_REQUEST['event_id'];
    $rsvp['user_id'] = $_SESSION['user_id'];
    $rsvp['rsvp'] = $_REQUEST['rsvp'];
    
    // Retrieve existing RSVP
    $sql = $pdo->prepare("SELECT * FROM event_rsvp WHERE user_id = ? and event_id = ?");
    $sql->execute([$_SESSION['user_id'], $rsvp['event_id']]);
    $response = $sql->fetch();
    
    if ($response) {
        // Already have an RSVP, update it!
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = $pdo->prepare("UPDATE event_rsvp set rsvp_status = :rsvp, rsvp_datetime = now() where user_id = :user_id and event_id = :event_id")->execute($rsvp);

            if ($result) {
                header('location: index.php?section=events&page=detail&event_id=' . $rsvp['event_id']);
            } else {
                $error = "Nope.";
            }

        } catch (PDOException $e) {
            $existingkey = "Integrity constraint violation: 1062 Duplicate entry";
            if (strpos($e->getMessage(), $existingkey) !== FALSE) {

                // Take some action if there is a key constraint violation, i.e. duplicate name
            } else {
                throw $e;
            }

            $error = "Duplicate account. Perhaps you forgot your password?";
        }
    } else {
        // New response - record it!
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = $pdo->prepare("INSERT INTO event_rsvp VALUES (NULL,:event_id,:user_id,:rsvp,now())")->execute($rsvp);

            if ($result) {
                header('location: index.php?section=events&page=detail&event_id=' . $rsvp['event_id']);
            } else {
                $error = "Nope.";
            }

        } catch (PDOException $e) {
            $existingkey = "Integrity constraint violation: 1062 Duplicate entry";
            if (strpos($e->getMessage(), $existingkey) !== FALSE) {

                // Take some action if there is a key constraint violation, i.e. duplicate name
            } else {
                throw $e;
            }

            $error = "Duplicate account. Perhaps you forgot your password?";
        }

    }

}
