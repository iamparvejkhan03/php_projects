<?php
    include("database.php");
    include("send_email.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("links.php") ?>
    <title>Email</title>
</head>
<body>
    <div class="form_container">
        <div id="password_reset_email_form">
            <h2>ENTER USER E-MAIL</h2><br>
            <form action="<?php echo htmlentities($_SERVER['REQUEST_URI']) ?>" method="post">
                <input type="email" name="email" placeholder="ENTER E-MAIL" id="email"><br><br>
                <input type="submit" name="send" value="SEND EMAIL ➡">
            </form>
        </div>
    </div>
</body>
</html>

<?php
    if(isset($_POST['send'])){
        $email = $_POST['email'];
        $select = "SELECT * FROM users WHERE email = '$email'";
        $mysqli_select_query = mysqli_query($conn, $select);
        if(mysqli_num_rows($mysqli_select_query)>0){
            $email = null;
            $username = null;
            $full_name = null;
            $token = null;
            $verification_url = null;
            while($rows = mysqli_fetch_assoc($mysqli_select_query)){
                $email = $rows['email'];
                $username = $rows['username'];
                $full_name = $rows['full_name'];
                $token = $rows['token'];
                $verification_url = "http://localhost/projects/php_projects/crudBasic/reset_password.php?token={$token}";
            }
            send_email($email, $full_name, $verification_url);
            session_start();
            $_SESSION['login_notice'] = "Please check your inbox";
            $_SESSION['username'] = $username;
        }else{
            echo "Invalid Email!";
        }
    }
?>