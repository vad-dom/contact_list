<?php
    class Contacts extends Model {

        public function __construct()
        {
            parent::__construct('test_contacts');
        }

        public function getFullContactList() {
            return $this->getFullData(
                ['id', 'contact_name', 'contact_code', 'contact_phone'], ['id'], true);
        }

        public function addContact($contact_name, $contact_code, $contact_phone) {
            return $this->insertData(
                [
                    'contact_name' => $contact_name, 
                    'contact_code' => $contact_code, 
                    'contact_phone' => $contact_phone
                ]
            );
        }

        public function deleteContact($contact_id) {
            return $this->deleteData(['id' => $contact_id]);
        }

    }
?>
