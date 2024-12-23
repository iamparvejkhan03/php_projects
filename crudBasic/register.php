<?php
    include("database.php");
    include("google_client.php");
    if(!isset($_SESSION)){
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("links.php") ?>
    <title>Register</title>
</head>
<body>
    <?php include("logout_header.php") ?>
    <div class="main">
        <div class="form">
            <h2>REGISTER NOW!</h2><br><br>
            <?php
                if(isset($_POST['register'])){
                    $full_name = $_POST['full_name'];
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $user_password = $_POST['password'];
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $token = bin2hex(random_bytes(15));
                    $account_status = "inactive";
                    $activation_url = "http://localhost/projects/php_projects/crudBasic/account_activation.php?token={$token}";

                    $select = "SELECT * FROM users WHERE username = '$username'";
                    $mysqli_select_query = mysqli_query($conn, $select);

                    if(mysqli_num_rows($mysqli_select_query)>0){
                        echo "<p style='color:red'>Username not available!</p>";
                    }else{
                        $select = "SELECT * FROM users WHERE email = '$email'";
                        $mysqli_select_query = mysqli_query($conn, $select);
                        if(mysqli_num_rows($mysqli_select_query)>0){
                            echo "<p style='color:red'>Email already exists!</p>";
                        }else{
                            $insert = "INSERT INTO users (full_name, username, email, password, token, account_status, online_status) VALUES ('$full_name', '$username', '$email', '$password', '$token', '$account_status','online')";
                            $mysqli_insert_query = mysqli_query($conn, $insert);
                            // echo "<p style='color:green'>User created!</p>";
                            $_SESSION['username'] = $username;
                            $_SESSION['password'] = $password;
                            $_SESSION['online_status'] = 'online';
                            $_SESSION['login_notice'] = "<p style='color:green'>Your account has been created! Please check your inbox and activate your account by clicking on the link.</p>";

                            setcookie("username", "{$username}", (time()+86400*30));
                            setcookie("password", "{$user_password}", (time()+86400*30));

                            include("send_email.php");
                            $subject = "Registration Successful!";
                            $body = "<h1>Hello, {$full_name}!</h1><p>Your account has been created on the website. Please activate your account by clicking on this link: <br> {$activation_url}</p>";
                            $success_message = "<p style='color:green'>Account created! Please check your email and activate your account.</p>";
                            $header = "Location: login.php";
                            send_email($email, $full_name, $subject, $body, $success_message, $header);
                        }
                    }
                }

            ?>
            <form action="register.php" method="post">
                <input type="text" placeholder="FULL NAME" name="full_name" required><br><br>
                <input type="text" name="username" placeholder="USERNAME" required><br><br>
                <input type="email" name="email" placeholder="EMAIL ADDRESS" required><br><br>
                <input type="password" name="password" placeholder="PASSWORD" required><br><br>
                <!-- <input type="submit" name="register" value="REGISTER"><br><br> -->
                <button class="full_width_button" name="register">REGISTER</button><br><br>
                <!-- <p><a href="<?php echo $google_client->createAuthUrl(); ?>" class="google_login_button"><img height="25px" width="25px" src="https://cdn-icons-png.flaticon.com/512/300/300221.png">&nbsp; CONTINUE WITH GOOGLE</a></p><br> -->
                <button class="full_width_button" onclick='event.preventDefault(); location.href="<?php echo $google_client->createAuthUrl(); ?>"'><img height="15px" width="15px" src="https://cdn-icons-png.flaticon.com/512/300/300221.png">&nbsp; CONTINUE WITH GOOGLE</button><br><br>
                <p>ALREADY A USER? <a href="login.php">LOGIN NOW</a></p><br>
            </form>
        </div>
    </div>
    <?php include_once("footer.php") ?>
    <button class="scroll_to_top"><i class="fa-solid fa-angle-up"></i></button>
</body>
</html>