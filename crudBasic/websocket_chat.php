<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include_once("links.php");
    include_once("database.php");
    $message = null;
    ?>
    <title>WEBSOCKET CHAT</title>
</head>
<body>
    <?php 
        include_once("header.php");
        $sender_id = $_SESSION['my_id'];
        $receiver_id = $_GET['receiver_id'];
    ?>
        <article class="main main_alike_with_styling">
        <section class="form chat_box">
            <div class="chat_box_header">
            <button onclick="location.href = 'users.php?sender_id=<?php echo $sender_id ?>'" class="no_background_button"><i class="fa fa-arrow-left"></i></button>
                <div class="card_author_info">
                
                <?php
                    //SELECT PIC FROM USERS FOR SENDER AND RECEIVER
                    $select_pic = "SELECT id, pic FROM users WHERE id = '$sender_id' OR id = '$receiver_id'";
                    $mysqli_select_pic_query = mysqli_query($conn, $select_pic);
                    while($rows = mysqli_fetch_assoc($mysqli_select_pic_query)){
                        switch($rows['id']){
                            case $receiver_id:
                                $receiver_pic = $rows['pic'];
                                break;
                            case $sender_id:
                                $sender_pic = $rows['pic'];
                                break;
                        }
                    }
                ?>
                    <img src="<?php echo $receiver_pic ?>" alt="user_img">
                    <div class="card_author_name_date">
                        <h4>Sahid Khan</h4>
                        <p class="small_text active_now_text success_text">Active now</p>
                    </div>
                </div>
            </div>
            <div class="chat_box_body">
                <?php

                    //SELECT ALL MESSAGES TO SHOW ON REFRESH STORED IN DB
                    $select = "SELECT * FROM messages WHERE (sender_id = '$sender_id' AND receiver_id = '$receiver_id') OR (sender_id = '$receiver_id' AND receiver_id = '$sender_id') ORDER BY msg_id ASC";
                    $mysqli_select_query = mysqli_query($conn, $select);

                    while($rows = mysqli_fetch_assoc($mysqli_select_query)){
                        if($sender_id == $rows['sender_id']){
                            echo "<div class='sender_msg'><img width='40px' height='40px' src='{$sender_pic}'><p class='light_background float_left message_text'>{$rows['message_text']}</p></div>";
                        }else{
                            echo "<div class='receiver_msg'><p class='dark_background float_right message_text'>{$rows['message_text']}</p></div>";
                        }
                    }
                ?>
            </div>
            <div class="chat_box_footer">
                <div class="like_form">
                    <textarea placeholder="Type message here..." class="background_input" type="text" name="message"></textarea>
                    <button name="send"><i class="fa fa-paper-plane"></i></button>
                </div>
            </div>
            
            <script type="module">
                import socket from "./websocket.js";
                let sender_id = <?php echo $sender_id ?>;
                let receiver_id = <?php echo $receiver_id ?>;
                let send_button = document.querySelector("button[name=send]");
                let message = document.querySelector("textarea[name=message]");
                let chat_box_body = document.querySelector(".chat_box_body");

                send_button.addEventListener("click", function(){

                    //Send the details for token generation
                    socket.send(JSON.stringify({
                        type : 'token',
                        sender_id : sender_id,
                        receiver_id : receiver_id
                    }));

                    //Send message button click event
                    socket.send(JSON.stringify({
                        type : 'message',
                        message_text : message.value,
                        sender_id : sender_id,
                        receiver_id : receiver_id,
                    }));

                    //Send the notification on click event
                    socket.send(JSON.stringify({
                        type : 'notification',
                        message_text : message.value,
                        receiver_id : receiver_id,
                        sender_id : sender_id
                    }));

                    chat_box_body.innerHTML += `<div class='sender_msg'><img width='40px' height='40px' src='<?php echo $sender_pic ?>'><p class='light_background float_left message_text'>${message.value}</p></div>`;
                    message.value = "";
                    chat_box_body.scrollTop = chat_box_body.scrollHeight;
                })

                // Listen for messages
                socket.onmessage = (event) => {
                    let data = JSON.parse(event.data);
                    console.log("Message received by receiver:", data);
                        if (data.type === 'message' && data.sender_id !== sender_id) {
                        chat_box_body.innerHTML += `<div class='receiver_msg'><p class='dark_background float_right message_text'>${data.message_text}</p></div>`;
                        chat_box_body.scrollTop = chat_box_body.scrollHeight;
                        }

                        if(data.type === 'notification'){
                            alert(data.message_text);
                        }
                };

                //Scroll chat box body to bottom
                window.addEventListener("load", function(){
                    chat_box_body.scrollTop = chat_box_body.scrollHeight;
                })

                message_counter.textContent = 0;
                console.log(message_counter);
                document.cookie = `message_counter=${message_counter.textContent}`;
            </script>
        </section>
    </article>
    <?php include_once("footer.php");?>
    <button class="scroll_to_top"><i class="fa-solid fa-angle-up"></i></button>
</body>
</html>

