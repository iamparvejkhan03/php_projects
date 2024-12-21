<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include_once("links.php");
    include_once("database.php");
    session_start();
    $sender_id = $_SESSION['my_id'];
    $receiver_id = $_GET['id'];
    $message = null;
    // $token = null;
    
    ?>
    <title>WEBSOCKET CHAT</title>
</head>
<body>
    <?php include_once("header.php");?>
        <article class="main main_alike_with_styling">
        <section class="form chat_box">
            <div class="chat_box_header">
                <div class="card_author_info">
                    <img src="upload/SahidKhanImage.jpg" alt="user_img">
                    <div class="card_author_name_date">
                        <h4>Sahid Khan</h4>
                        <p class="small_text active_now_text success_text">Active now</p>
                    </div>
                </div>
            </div>
            <div class="chat_box_body">
                <?php
                    $select = "SELECT * FROM messages WHERE (sender_id = '$sender_id' AND receiver_id = '$receiver_id') OR (sender_id = '$receiver_id' AND receiver_id = '$sender_id') ORDER BY msg_id ASC";
                    $mysqli_select_query = mysqli_query($conn, $select);
                    while($rows = mysqli_fetch_assoc($mysqli_select_query)){
                        if($sender_id == $rows['sender_id']){
                            echo "<div class='sender_msg'><p class='light_background float_left message_text'>{$rows['message_text']}</p></div>";
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
            <script>
                let sender_id = <?php echo $sender_id ?>;
                let receiver_id = <?php echo $receiver_id ?>;
                let token = "";
                const socket = new WebSocket("ws://127.0.0.1:8080");
                let send_button = document.querySelector("button[name=send]");
                let message = document.querySelector("textarea[name=message]");
                let chat_box_body = document.querySelector(".chat_box_body");

                //Send message button click event
                send_button.addEventListener("click", function(){
                    fetch(`get_token.php?receiver_id=${receiver_id}`).then(response => response.json()).then(data => {token = data; console.log(`Token is: ${token}`)});
                    socket.send(JSON.stringify({
                        message_text : message.value,
                        sender_id : sender_id,
                        receiver_id : receiver_id,
                        token : token
                    }));
                    // socket.send(JSON.stringify({
                    //     receiver_id : receiver_id,
                    //     sender_id : sender_id,
                    //     message_text : message.value
                    // }));

                    chat_box_body.innerHTML += `<div class='sender_msg'><p class='light_background float_left message_text'>${message.value}</p></div>`;
                    // fetch("send_database.php",{
                    //     method : 'POST',
                    //     headers : {
                    //         'Content-Type' : 'application/x-www-form-urlencoded',
                    //     },
                    //     body : `message=${encodeURIComponent(message.value)}&sender_id=${encodeURIComponent(sender_id)}&receiver_id=${encodeURIComponent(receiver_id)}`
                    // }).then(response => response.text()).then(data => {
                    //     console.log(data);
                    //     message.value = "";
                    // });
                    message.value = "";
                })

                //Scroll chat box body to bottom
                window.addEventListener("load", function(){
                    chat_box_body.scrollTop = chat_box_body.scrollHeight;
                })

                // Connection opened
                socket.onopen = () => {
                    console.log('Connected to WebSocket server');
                    // fetch(`get_token.php?receiver_id=${receiver_id}`).then(response => response.json()).then(data => {token = data; console.log(`Token is: ${token}`)});
                    // socket.send(JSON.stringify({
                    //     message_text : '',
                    //     sender_id : sender_id,
                    //     receiver_id : receiver_id,
                    //     token : token
                    // }));
                };

                // Listen for messages
                socket.onmessage = (event) => {
                    data = JSON.parse(event.data);
                    console.log("Message received by receiver:", data);
                        if (data.sender_id !== sender_id && data.receiver_id === sender_id && data.token == token) {
                        chat_box_body.innerHTML += `<div class='receiver_msg'><p class='dark_background float_right message_text'>${data.message_text}</p></div>`;
                        }
                };

                // socket.onmessage(message);

                // Handle errors
                socket.onerror = (error) => {
                    console.log('WebSocket error:', error);
                };

                // Handle connection close
                socket.onclose = () => {
                    console.log('Connection closed');
                };

            </script>
        </section>
    </article>
    <?php include_once("footer.php");?>
    <button class="scroll_to_top"><i class="fa-solid fa-angle-up"></i></button>
</body>
</html>

