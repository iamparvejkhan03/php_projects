<?php
    require_once 'vendor/autoload.php';
    $google_client = new Google_Client();
    $google_client->setClientId('782946008987-dlvuse5eec23necqjj286is7p4vs3g0q.apps.googleusercontent.com');
    $google_client->setClientSecret('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');
    $google_client->setRedirectUri('http://localhost/Projects/php_projects/googlogBasic/index.php');
    $google_client->addScope('email');
    $google_client->addScope('profile');
?>