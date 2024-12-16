<?php
    include("database.php");
    include("google_client.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("links.php") ?>
    <title>Register</title>
</head>
<body>
    <div class="form_container">
        <div id="register_form">
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
                            $insert = "INSERT INTO users (full_name, username, email, password, token, account_status) VALUES ('$full_name', '$username', '$email', '$password', '$token', '$account_status')";
                            $mysqli_insert_query = mysqli_query($conn, $insert);
                            echo "<p style='color:green'>User created!</p>";
                            session_start();
                            $_SESSION['username'] = $username;
                            $_SESSION['login_notice'] = "<p>Please check your inbox and verify your email first. </p>";

                            setcookie("username", "{$username}", (time()+86400*30));
                            setcookie("password", "{$user_password}", (time()+86400*30));

                            include("send_email.php");
                            send_email($email, $full_name, $activation_url);
                        }
                    }
                }

            ?>
            <form action="register.php" method="post">
                <input type="text" placeholder="FULL NAME" name="full_name"><br><br>
                <input type="text" name="username" placeholder="USERNAME"><br><br>
                <input type="email" name="email" placeholder="EMAIL ADDRESS"><br><br>
                <input type="password" name="password" placeholder="PASSWORD"><br><br>
                <input type="submit" name="register" value="REGISTER"><br><br>
                <p><a href="<?php echo $google_client->createAuthUrl(); ?>" class="google_login_button"><img height="25px" width="25px" src="https://cdn-icons-png.flaticon.com/512/300/300221.png">&nbsp; CONTINUE WITH GOOGLE</a></p><br>
                <p>ALREADY A USER? <a href="login.php">LOGIN NOW</a></p><br>
            </form>
        </div>
    </div>
</body>
</html>