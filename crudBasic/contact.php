<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        include_once("links.php"); 
        include_once("send_email.php"); 
        // session_start();
    ?>
    <title>CONTACT US</title>
</head>
<body>
    <?php if(isset($_SESSION['username']) && isset($_SESSION['password'])){
            include_once("header.php");
        }else{
            include_once("logout_header.php");
        }
    ?>
    <div class="main">
        <div class="left_panel">
            <img src="upload/SahidKhanImage.jpg" alt="">
        </div>
        <div class="form right_panel">
            
            <h2>CONTACT US</h2><br>
            <form action="<?php echo htmlentities($_SERVER['REQUEST_URI']) ?>" method="post">
                <input type="text" name="user_full_name" placeholder="FULL NAME" required><br><br>
                <input type="email" name="user_email" placeholder="E-MAIL ADDRESS" required><br><br>
                <input type="text" name="user_subject" placeholder="SUBJECT" required><br><br>
                <textarea name="user_message" required placeholder="YOUR MESSAGE GOES HERE"></textarea><br><br>
                <input type="file" name="user_file"><br><br>
                <button class="full_width_button" name="send">SEND MESSAGE <i class="fa fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
                $destination = null;
                if(isset($_POST['send'])){
                    $user_full_name = $_POST['user_full_name'];
                    $user_email = $_POST['user_email'];
                    $user_subject = $_POST['user_subject'];
                    $user_message = $_POST['user_message'];
                    if(isset($_FILES['user_file'])){
                        $user_file = $_FILES['user_file'];
                        $_SESSION['user_file'] = $user_file;
                        $tmp_name = $_FILES['user_file']['tmp_name'];
                        $file_name = $_FILES['user_file']['name'];
                        $destination = "upload/".$file_name;
                        move_uploaded_file($tmp_name, $destination);
                    }
                    $admin_full_name = "Admin";
                    $admin_email = "formyclient347@gmail.com";
                    $admin_subject = "New Contact Form Query";
                    $body = "Hi {$admin_full_name}, you have received a new query and it's details are below:<br><br>
                    Full Name: {$user_full_name}<br><br>
                    E-mail: {$user_email}<br><br>
                    Subject: {$user_subject}<br><br>
                    Message: {$user_message}<br><br>
                    Attached File:{$destination}";
                    $header = "Refresh: 5";
                    $success_message = "<p style='color:green'>Message sent!</p>";
                    send_email($admin_email, $admin_full_name, $admin_subject, $body, $success_message, $header);
                    if(isset($_SESSION['login_notice'])){
                        echo $_SESSION['login_notice'];
                    }
                }
            ?>