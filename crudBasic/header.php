<?php
    include_once("links.php");
    include_once("database.php");
    if(!isset($_SESSION)){
        session_start();
    }
    $sender_id = $_SESSION['my_id'];
?>

<div class="header">
    <a href='<?php echo "index.php?sender_id={$sender_id}" ?>'><img height="50px" src="upload/logo.png" alt="logo"></a>
    <div id="navbar">
        <ul>
            <li><a href='<?php echo "index.php?sender_id={$sender_id}" ?>'>HOME</a></li>
            <li><a href='<?php echo "blog.php?sender_id={$sender_id}" ?>'>BLOG</a></li>
            <li><a href='<?php echo "contact.php?sender_id={$sender_id}" ?>'>CONTACT</a></li>
            <li><a href='<?php echo "users.php?sender_id={$sender_id}" ?>'>ALL USERS</a></li>
        </ul>
    </div>

    <div class="username_in_header">
        <button onclick='location.href="users.php?sender_id=<?php echo $sender_id?>"' class="no_background_button"><i class="far fa-comment-alt"></i><span class="message_counter"><?php if(isset($_COOKIE['message_counter'])){echo $_COOKIE['message_counter'];} ?></span></button>
        <img src=<?php if(!empty($_SESSION['pic'])){echo $_SESSION['pic'];}else{ echo "https://cdn-icons-png.flaticon.com/512/149/149071.png";}?> height="50px" width="50px" alt="user_img">
        <a href="profile.php"><?php 
            try{
                $username = $_SESSION['username'];
                echo $_SESSION['username'];
            }catch(error){
                echo "Error occured!";
            }
        ?></a>
        <form action="users.php" method="post">
            <!-- <input type="submit" name="logout" value="LOG OUT"> -->
            <button name="logout">LOG OUT <i class="fa fa-sign-out"></i></button>
        </form>&nbsp;
        <button class="mode_btn" name="mode"><i class="fas fa-sun" aria-hidden="true"></i></button>
    </div>
</div>

<script type="module">
    import socket from "./websocket.js";

    socket.onmessage = (event) => {
        let data = JSON.parse(event.data);
        if(data.type === "notification_established"){
            console.log(data.message_text);
        }
        if(data.type === 'notification'){
            // let message_counter = document.querySelector(".message_counter");
            // if(message_counter.textContent == 0){
            //     message_counter.style.display = 'none';
            // }else{
                message_counter.style.display = "block";
            // }
            console.log(message_counter.textContent);
            message_counter.textContent++;
            document.cookie = `message_counter=${message_counter.textContent}`;
            alert(data.message_text);
            console.log(message_counter.textContent);
        }
    }
</script>

<?php
    $update = "UPDATE users SET online_status = 'offline' WHERE username = '$username'";
    if(!isset($username)){
        $mysqli_update_query = mysqli_query($conn, $update);
    }
    if(isset($_POST['logout'])){
        $mysqli_update_query = mysqli_query($conn, $update);
        session_destroy();
        header("Location: index.php");
    }
?>