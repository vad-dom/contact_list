<?php
    require_once 'settings.php';

    $contact_name = $_POST['contact_name']?? false;
    $contact_code = $_POST['contact_code']?? false;
    $contact_phone = $_POST['contact_phone']?? false;

    if ($contact_name && $contact_code && $contact_phone) {
        $contacts = new Contacts();
        echo json_encode($contacts->addContact($contact_name, $contact_code, $contact_phone));
    }
?>