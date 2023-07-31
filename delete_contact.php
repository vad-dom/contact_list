<?php
    require_once 'settings.php';

    $contact_id = $_POST['contact_id']?? false;

    if ($contact_id) {
        $contacts = new Contacts();
        if ($contacts->dbIsNull()) echo json_encode(['result' => false]);
        else echo json_encode($contacts->deleteContact($contact_id));
    }
?>