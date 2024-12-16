<?php
    require_once 'vendor/autoload.php';
    $google_client = new Google_Client();
    $google_client->setClientId('782946008987-nqv899jekd842oc6bkbk558voipt12qm.apps.googleusercontent.com');
    $google_client->setClientSecret('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');
    $google_client->setRedirectUri('http://localhost/Projects/php_projects/crudBasic/google_registration.php');
    $google_client->addScope('email');
    $google_client->addScope('profile');
?>