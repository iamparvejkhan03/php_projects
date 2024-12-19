<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $message = $_POST['message'];
        $sender_id = $_POST['sender_id'];
        $receiver_id = $_POST['receiver_id'];
        include_once("database.php");
        $insert = "INSERT INTO messages (sender_id, receiver_id, message_text) VALUES ('$sender_id', '$receiver_id', '$message')";
        $mysqli_insert_query = mysqli_query($conn, $insert);
        if($mysqli_insert_query){
            echo "Message inserted into database.";
        }else{
            echo "Could not insert the message into database.";
        }
    }
?>