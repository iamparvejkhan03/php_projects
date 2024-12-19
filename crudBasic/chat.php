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
    $message = null;
    ?>
    <title>CHAT</title>
</head>
<body>
    <?php include_once("header.php");?>
        <article class="main main_alike_with_styling">
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
        <section class="form chat_box">
            <div class="chat_box_header">
                <button onclick="location.href = 'users.php'" class="no_background_button"><i class="fa fa-arrow-left"></i></button>
                <div class="card_author_info">
                    <img src="<?php echo $pic ?>" alt="user_img">
                    <div class="card_author_name_date">
                        <h4><?php echo $full_name ?></h4>
                        <p class="small_text success_text">Active now</p>
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
                    $select = "SELECT * FROM messages WHERE (sender_id = '$my_id' AND receiver_id = '$id') OR (sender_id = '$id' AND receiver_id = '$my_id') ORDER BY msg_id ASC";
                    $mysqli_select_query = mysqli_query($conn, $select);
                    if(mysqli_num_rows($mysqli_select_query)>0){
                        while($rows = mysqli_fetch_assoc($mysqli_select_query)){
                            $sender_id = $rows['sender_id'];
                            $receiver_id = $rows['receiver_id'];
                            if($sender_id == $my_id){
                                echo "<div><img width='40px' height='40px' src='{$my_pic}'><p class='light_background message_text'>{$rows['message_text']}</p></div>";
                                // if()
                            }else{
                                echo "<div class='receiver_msg'><p class='dark_background float_right message_text'>{$rows['message_text']}</p></div>";
                            }
                        }
                    }else{
                        echo "<h2 style='text-align:center; color:black; position: absolute; top: 50%; left:50%; transform:translate(-50%, -50%)'>Start messaging...</h2>";
                    }
                ?>
            </div>
            <div class="chat_box_footer">
                <?php
                    if(isset($_POST['send'])){
                        $message = $_POST['message'];
                        $insert = "INSERT INTO messages (sender_id, receiver_id, message_text) VALUES ('$my_id', '$id', '$message')";
                        $mysqli_insert_query = mysqli_query($conn, $insert);
                        echo "<script>location.href = '{$_SERVER['REQUEST_URI']}';</script>";
                    }
                ?>
                <form action="<?php echo htmlentities($_SERVER['REQUEST_URI']) ?>" method="post" enctype="multipart/form-data">
                    <textarea placeholder="Type message here..." class="background_input" type="text" name="message"></textarea>
                    <button name="send"><i class="fa fa-paper-plane"></i></button>
                </form>
            </div>
        </section>
    </article>
    <?php include_once("footer.php");?>
</body>
</html>