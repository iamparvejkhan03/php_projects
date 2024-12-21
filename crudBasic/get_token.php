<?php
    include_once("database.php");
    session_start();
    $sender_id = $_SESSION['my_id'];
    $receiver_id = $_GET['receiver_id'];
    $select = "SELECT token FROM messages WHERE (sender_id = '$sender_id' AND receiver_id = '$receiver_id') OR (receiver_id = '$sender_id' AND sender_id = '$receiver_id')";
    $mysqli_select_query = mysqli_query($conn, $select);
    if(mysqli_num_rows($mysqli_select_query)>0){
        while($rows = mysqli_fetch_assoc($mysqli_select_query)){
            // print_r($rows);
            $token = $rows['token'];
        }
    }else{
        $token = null;
    }
    echo json_encode($token);
?>