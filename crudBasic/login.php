<?php
    include("database.php");
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
            <h2>LOGIN NOW!</h2><br><br>
            <form action="login.php" method="post">
                <input type="text" name="username" placeholder="USERNAME"><br><br>
                <input type="password" name="password" placeholder="PASSWORD"><br><br>
                <input type="submit" name="login" value="LOGIN">
            </form><br>
            <p>NOT REGSITERED YET? <a href="register.php">SIGN UP NOW</a></p>
        </div>
    </div>
</body>
</html>

<?php
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $select = "SELECT password FROM users WHERE username = '$username' AND password = '$password'";
        $mysqli_select = mysqli_query($conn, $select);
        
        if(!$mysqli_select){
            echo "Could not fetch user!";
        }else{
            foreach($mysqli_select as $arr){
                foreach($arr as $key=>$value){
                    if($value == $password){
                        session_start();
                        $_SESSION['username'] = $username;
                        $_SESSION['password'] = $password;
                        header('Location: users.php');
                    }
                }
            }
        }
    }
?>