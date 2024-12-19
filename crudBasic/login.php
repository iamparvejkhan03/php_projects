<?php
    include("database.php");
    include_once("google_client.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("links.php") ?>
    <title>Login</title>
</head>
<body>
    <?php include("logout_header.php") ?>
    <div class="main">
        <div class="form">
            <p><?php if(isset($_SESSION['login_notice'])){echo $_SESSION['login_notice'];} ?></p><br>
            <h2>LOGIN NOW!</h2><br>
            <?php
                $password_input_type = "password";
                $id = null;
                if(isset($_POST['login'])){
                    $username = $_POST['username'];
                    $password = ($_POST['password']);

                    $select = "SELECT * FROM users WHERE username = '$username'";
                    $mysqli_select = mysqli_query($conn, $select);
                    if(mysqli_num_rows($mysqli_select)==0){
                        echo "<p style='color:red'>User doesn't exist!</p>";
                    }else{
                        $_SESSION['username'] = $username;
                        while($rows = mysqli_fetch_assoc($mysqli_select)){
                            $id =$rows['id'];
                            $_SESSION['my_id'] = $id;
                            if($rows['account_status'] == "active"){
                                if(password_verify($password, $rows['password']) || $password == $rows['password']){
                                    // $_SESSION['username'] = $username;
                                    $_SESSION['password'] = $password;
                                    $_SESSION['full_name'] = $rows['full_name'];
                                    $_SESSION['email'] = $rows['email'];
                                    $update = "UPDATE users SET online_status = 'online' WHERE id = '$id'";
                                    $mysqli_update_query = mysqli_query($conn, $update);
                                    header('Location: profile.php');
                                }else{
                                    echo "<p style='color: red'>Password is wrong!</p>";
                                }
                            }else{
                                echo "<p style='color: red'>Your account is not active yet. Please check your inbox and verify your email first! <a href='resend_activation_email.php'>Click here to resend verification email.</a></p>";
                            }
                        }
                    }
                    
                }
            ?>
            <form action="login.php" method="post">
                <input type="text" name="username" value="<?php if(isset($_COOKIE['username'])){echo $_COOKIE['username'];} ?>" placeholder="USERNAME" required><br><br>
                <button class="eye_icon"><i class="far fa-eye"></i></button>
                <script>
                    let eye_icon = document.getElementById("eye_icon");
                    eye_icon.addEventListener("click", function(e){
                        e.preventDefault();
                        $password_input_type = "text";
                        console.log($password_input_type);
                    })
                </script>
                <input type="<?php echo $password_input_type; ?>" name="password" value="<?php if(isset($_COOKIE['password'])){echo $_COOKIE['password'];} ?>" placeholder="PASSWORD" required><br><br>
                <button class="full_width_button" name="login">LOGIN</button><br><br>
                <!-- <input type="submit" name="login" value="LOGIN"><br><br> -->
                <button class="full_width_button" onclick='event.preventDefault(); location.href="<?php echo $google_client->createAuthUrl(); ?>"'><img height="15px" width="15px" src="https://cdn-icons-png.flaticon.com/512/300/300221.png">&nbsp; CONTINUE WITH GOOGLE</button><br>
            </form><br>
            <p>FORGOT PASSWORD? <a href="password_reset_email.php">CLICK TO RESET</a></p><br>
            <p>NOT REGISTERED YET? <a href="register.php">SIGN UP NOW</a></p>
        </div>
    </div>
    <?php include_once("footer.php") ?>
</body>
</html>