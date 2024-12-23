<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        include_once("links.php");
        include_once("header.php");
        $sender_id = $_SESSION['my_id'];
    ?>
    <title>All Users</title>
    <script>
        // let start_chat_button = document.querySelector(".start_chat_button");
        //     start_chat_button.addEventListener("click", function(){
        //         location.href = "chat.php";
        //     })
        function start_chat_button(id){
                // location.href = `chat.php?id=${id}`;
                location.href = `websocket_chat.php?receiver_id=${id}&sender_id=<?php echo $_SESSION['my_id'] ?>`;
            }
    </script>
</head>
<body>
    <?php 
        // include_once("header.php");
        include("database.php");
        // $session = session_start();

        if(!isset($_SESSION['username'])){
            ?>
                <script>
                    location.href = "login.php";
                </script>
            <?php
        }else{
            $username = $_SESSION['username'];
        }  
    ?>
    
    <div class="main">
        <table>
            <caption>ONLINE USERS</caption>
            <tr>
                <th>PHOTO</th>
                <th>USERNAME</th>
            </tr>
            <?php
                // if($session){
                    $select = "SELECT * FROM users WHERE online_status = 'online' AND username != '$username'";
                    $mysqli_select = mysqli_query($conn, $select);
                    if($mysqli_select){
                        while($row = mysqli_fetch_assoc($mysqli_select)){
                            // $half_email = explode("@", $row['email'])[0];
                            // print_r($half_email);
                            $receiver_id = $row['id'];
                            echo "<tr>
                                    <td><img style='border-radius: 50%' width='50px' src={$row['pic']}><i class='online_status_icon fa-solid fa-circle'></i></td>
                                    <td>{$row['username']}</td>
                                    <td><button onclick='start_chat_button($receiver_id)' class='start_chat_button' type='button'>CHAT <i class='fa-brands fa-rocketchat'></i></button></td>
                                </tr>";
                        }
                    }else{
                        echo "Query failed: ". mysqli_error($conn);
                    }
                // }
            ?>
        </table>
        <table>
            <caption>MY PREVIOUS CHATS</caption>
            <tr>
                <th>PHOTO</th>
                <th>USERNAME</th>
                <th>LAST MESSAGE</th>
                <!-- <th>ONLINE STATUS</th> -->
            </tr>
            <?php

                // if($session){
                    $select_tokens = "SELECT DISTINCT token FROM messages WHERE sender_id = '$sender_id' OR receiver_id = '$sender_id' ORDER BY msg_id ASC";
                    $mysqli_select_tokens = mysqli_query($conn, $select_tokens);
                    if($mysqli_select_tokens){
                        while($rows = mysqli_fetch_assoc($mysqli_select_tokens)){
                            // print_r($rows);
                            $token = $rows['token'];
                            $select_receiver_sender = "SELECT * FROM messages WHERE token = '$token' ORDER BY msg_id DESC LIMIT 1";
                            $mysqli_select_receiver_sender = mysqli_query($conn, $select_receiver_sender);
                            while($cols = mysqli_fetch_assoc($mysqli_select_receiver_sender)){
                                // print_r($cols);
                                $receiver_id = $cols['receiver_id'];
                                $sender_id = $cols['sender_id'];
                                $message_text = $cols['message_text'];
                                if($cols['sender_id']===$_SESSION['my_id']){
                                    $user_to_show = $receiver_id;
                                }else{
                                    $user_to_show = $sender_id;
                                }
                                $select_name_image = "SELECT * FROM users WHERE id = '$user_to_show'";
                                $mysqli_select_name_image = mysqli_query($conn, $select_name_image);
                                while($col = mysqli_fetch_assoc($mysqli_select_name_image)){
                                    // if($cols['sender_id'] !== $_SESSION['my_id']){
                                        $pic = $col['pic'];
                                        // echo $cols['sender_id']."<br>";
                                    // }
                                    $username = $col['username'];
                                    echo "<tr>
                                    <td><img style='border-radius: 50%' width='50px' src='{$pic}'><i class='online_status_icon fa-solid fa-circle'></i></td>
                                    <td>{$username}</td>
                                    <td>{$message_text}</td>
                                    <td><button onclick='start_chat_button({$user_to_show})' class='start_chat_button' type='button'>CHAT <i class='fa-brands fa-rocketchat'></i></button></td>
                                </tr>";
                                }
                                
                            }
                        }
                    }else{
                        echo "Query failed: ". mysqli_error($conn);
                    }
                // }
            ?>
        </table>
    </div>
    <?php include_once("footer.php") ?>
    <button class="scroll_to_top"><i class="fa-solid fa-angle-up"></i></button>
</body>
</html>