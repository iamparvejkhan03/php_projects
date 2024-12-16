<?php
  include_once("config.php");
  $login_button = $google_client->createAuthUrl();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Happy+Monkey&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="form_container">
        <div id="login_form">
            <p><?php if(isset($_SESSION['login_notice'])){echo $_SESSION['login_notice'];} ?></p><br>
            <h2>LOGIN NOW!</h2><br>
            <?php
                $password_input_type = "password";
                if(isset($_POST['login'])){
                    $username = $_POST['username'];
                    $password = $_POST['password'];

                    $select = "SELECT * FROM users WHERE username = '$username'";
                    $mysqli_select = mysqli_query($conn, $select);

                    if(mysqli_num_rows($mysqli_select)==0){
                        echo "<p style='color:red'>User doesn't exist!</p>";
                    }else{
                        $_SESSION['username'] = $username;
                        while($rows = mysqli_fetch_assoc($mysqli_select)){
                            if($rows['account_status'] == "active"){
                                if(password_verify($password, $rows['password']) || $password == $rows['password']){
                                    // $_SESSION['username'] = $username;
                                    $_SESSION['password'] = $password;
                                    header('Location: users.php');
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
                <input type="text" name="username" value="<?php if(isset($_COOKIE['username'])){echo $_COOKIE['username'];} ?>" placeholder="USERNAME"><br><br>
                <button id="eye_icon">👀</button>
                <script>
                    let eye_icon = document.getElementById("eye_icon");
                    eye_icon.addEventListener("click", function(e){
                        e.preventDefault();
                        $password_input_type = "text";
                        console.log($password_input_type);
                    })
                </script>
                <input type="<?php echo $password_input_type; ?>" name="password" value="<?php if(isset($_COOKIE['password'])){echo $_COOKIE['password'];} ?>" placeholder="PASSWORD"><br><br>
                <input type="submit" name="login" value="LOGIN">
            </form><br><br>
            <p><a class="google_login_button" href="<?php echo $login_button?>">CONTINUE WITH GOOGLE</a></p><br>
        </div>
    </div>
</body>
</html>

<!-- <script src="https://accounts.google.com/gsi/client" async defer></script>
<div id="g_id_onload"
     data-client_id="782946008987-dlvuse5eec23necqjj286is7p4vs3g0q.apps.googleusercontent.com"
     data-callback="handleCredentialResponse">
</div>
<script>
  function handleCredentialResponse(response) {
    console.log(response.credential); // Contains JWT
  }
</script> -->