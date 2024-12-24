<?php
    $db_server = "";
    $db_user = "";
    $db_pass = "";
    $db_name = "";
    $conn = null;

    try{
        $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    }catch(mysqli_sql_exception){
        echo "Could not connect database!";
    }
?>
