<?php
    include_once("database.php");
    session_start();
    $my_id = $_SESSION['my_id'];
    $id = $_SESSION['receiver_id'];
    $select_pic = "SELECT pic FROM users WHERE id = '$my_id'";
    $mysqli_select_pic_query = mysqli_query($conn, $select_pic);
    while($pic_row = mysqli_fetch_assoc($mysqli_select_pic_query)){
        $my_pic = $pic_row['pic'];
    }
    $select = "SELECT * FROM messages WHERE (sender_id = '$my_id' AND receiver_id = '$id') OR (sender_id = '$id' AND receiver_id = '$my_id') ORDER BY msg_id ASC";
    $mysqli_select_query = mysqli_query($conn, $select); 
    $messages = [];
    $sender_id = null;
    $receiver_id = null;
    if(mysqli_num_rows($mysqli_select_query)>0){
        while($rows = mysqli_fetch_assoc($mysqli_select_query)){
            $sender_id = $rows['sender_id'];
            $receiver_id = $rows['receiver_id'];
                $messages[] = [$rows['message_text'], $sender_id, $receiver_id];
        }
    }else{
    }
    echo  json_encode($messages);
?>