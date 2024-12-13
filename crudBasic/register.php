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
    <title>Register</title>
</head>
<body>
    <div class="form_container">
        <div id="register_form">
            <h2>REGISTER NOW!</h2><br><br>
            <form action="register.php" method="post">
                <input type="text" placeholder="FULL NAME" name="full_name"><br><br>
                <input type="text" name="username" placeholder="USERNAME"><br><br>
                <input type="email" name="email" placeholder="EMAIL ADDRESS"><br><br>
                <input type="password" name="password" placeholder="PASSWORD"><br><br>
                <input type="submit" name="register" value="REGISTER"><br><br>
                <p>ALREADY A USER? <a href="login.php">LOGIN NOW</a></p>
            </form>
        </div>
    </div>
</body>
</html>

<?php
    if(isset($_POST['register'])){
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $insert = "INSERT INTO users (full_name, username, email, password) VALUES ('$full_name', '$username', '$email', '$password')";

        $mysqli_query = mysqli_query($conn, $insert);
        try{
            if($mysqli_query){
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
                header('Location: users.php');
            }
        }catch(mysqli_sql_exception){
            echo "Could not created user!";
        }
    }
?>