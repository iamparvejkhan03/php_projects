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
            <?php
                if(isset($_POST['register'])){
                    $full_name = $_POST['full_name'];
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

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
                            $insert = "INSERT INTO users (full_name, username, email, password) VALUES ('$full_name', '$username', '$email', '$password')";
                            $mysqli_insert_query = mysqli_query($conn, $insert);
                            echo "<p style='color:green'>User created!</p>";
                            session_start();
                            $_SESSION['username'] = $username;
                            header("Location: users.php");
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
                <p>ALREADY A USER? <a href="login.php">LOGIN NOW</a></p>
            </form>
        </div>
    </div>
</body>
</html>