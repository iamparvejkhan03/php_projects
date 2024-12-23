<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("links.php") ?>
    <title>Reset Password</title>
</head>
<body>
<?php include("logout_header.php") ?>
<div class="main">
        <div class="form">
            <?php
                include("database.php");

                if(isset($_GET['token'])){
                    $token = $_GET['token'];
                    if(isset($_POST['set_password'])){
                        $new_password = $_POST['new_password'];
                        $hash_password = password_hash($new_password, PASSWORD_DEFAULT);
                        $confirm_password = $_POST['confirm_password'];
                        if($new_password !== $confirm_password){
                            echo "<p style='color:red'>Passwords do not match!</p>";
                        }else{
                            $update = "UPDATE users SET password = '$hash_password' WHERE token = '$token'";
                            $mysqli_update_query = mysqli_query($conn, $update);
                            if($mysqli_update_query){
                                // session_start();
                                $_SESSION['login_notice'] = "Password has been reset";
                                $username = $_SESSION['username'];
                                setcookie('username', "{$username}", (time()+86400*30));
                                setcookie('password', "{$new_password}", (time()+86400*30));
                                header("location: login.php");
                            }else{
                                echo "Could not reset password!";
                            }
                        }
                    }
                }else{
                    echo "<p style='color:red'>Invalid URL!</p><br>";
                }
            ?>
            <h2>RESET PASSWORD</h2><br>
            <form action="<?php echo htmlentities($_SERVER['REQUEST_URI']) ?>" method="post">
                <input type="password" name="new_password" placeholder="ENTER NEW PASSWORD"><br><br>
                <input type="password" name="confirm_password" placeholder="CONFIRM NEW PASSWORD"><br><br>
                <input type="submit" name="set_password" value="SET PASSWORD  ✔">
            </form>
        </div>
    </div>
    <?php include_once("footer.php") ?>
    <button class="scroll_to_top"><i class="fa-solid fa-angle-up"></i></button>
</body>
</html>