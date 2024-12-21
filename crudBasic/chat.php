<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include_once("links.php");
    include_once("database.php");
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }else{
        $username = $_SESSION['username'];
    }
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }else{
        echo "<p class='error_text'>Invalid URL! Could not fetch the ID.</p>";
    }
    $my_id = $_SESSION['my_id'];
    $_SESSION['sender_id'] = $id;
    $_SESSION['receiver_id'] = $id;
    $message = null;
    ?>
    <title>CHAT</title>
</head>
<body>
    <?php include_once("header.php");?>
        <article class="main main_alike_with_styling">
        <section class="form chat_box">
            <div class="chat_box_header">
            <?php
                $select = "SELECT * FROM users WHERE id = '$id'";
                $mysqli_select_query = mysqli_query($conn, $select);
                if($mysqli_select_query){
                    while($rows = mysqli_fetch_assoc($mysqli_select_query)){
                        $full_name = $rows['full_name'];
                        $pic = $rows['pic'];
                    }
                }else{
                    echo "<p class='error_text'>Query failed! Could not fetch the user.</p>";
                }
            ?>
                <button onclick="location.href = 'users.php'" class="no_background_button"><i class="fa fa-arrow-left"></i></button>
                <div class="card_author_info">
                    <img src="<?php echo $pic ?>" alt="user_img">
                    <div class="card_author_name_date">
                        <h4><?php echo $full_name ?></h4>
                        <p class="small_text active_now_text success_text">Active now</p>
                    </div>
                </div>
            </div>
            <div class="chat_box_body">
                <?php
                    $select_pic = "SELECT pic FROM users WHERE id = '$my_id'";
                    $mysqli_select_pic_query = mysqli_query($conn, $select_pic);
                    while($pic_row = mysqli_fetch_assoc($mysqli_select_pic_query)){
                        $my_pic = $pic_row['pic'];
                    }
                ?>
            </div>
            <div class="chat_box_footer">
                <div class="like_form">
                    <textarea placeholder="Type message here..." class="background_input" type="text" name="message"></textarea>
                    <button name="send"><i class="fa fa-paper-plane"></i></button>
                </div>
                <script>
                    let send = document.querySelector("button[name=send]");
                    let message = document.querySelector("textarea[name=message]");
                    let sender_id = <?php echo json_encode($my_id) ?>;
                    let receiver_id = <?php echo json_encode($id) ?>;
                    send.addEventListener("click", function(event){
                        event.preventDefault();
                        fetch("send_message.php", {
                            method : 'POST',
                            headers : {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body : `message=${encodeURIComponent(message.value)}&sender_id=${encodeURIComponent(sender_id)}&receiver_id=${encodeURIComponent(receiver_id)}`
                        }).then(response => response.text()).then(data => {
                            message.value = "";
                            console.log(data);
                            loadMessages();
                        })
                    })
                    let chat_box_body = document.querySelector(".chat_box_body");
                    function loadMessages(){
                        fetch("get_messages.php")
                        .then(response => response.json())
                        .then(datas => {
                            chat_box_body.innerHTML = "";
                                datas.forEach(data => {
                                    if(data[2] == <?php echo $id?>){
                                        chat_box_body.innerHTML += `<div><img width='40px' height='40px' src='<?php echo $my_pic?>'><p class='light_background message_text'>${data[0]}</p></div>`
                                    }else{
                                        chat_box_body.innerHTML += `<div class='receiver_msg'><p class='dark_background float_right message_text'>${data[0]}</p></div>`;
                                    }
                                    chat_box_body.scrollTop = chat_box_body.scrollHeight;
                            })
                        });
                    }
                    setInterval(()=>{
                        loadMessages();
                    }, 2000);
                </script>
            </div>
        </section>
    </article>
    <?php include_once("footer.php");?>
    <button class="scroll_to_top"><i class="fa-solid fa-angle-up"></i></button>
</body>
</html>