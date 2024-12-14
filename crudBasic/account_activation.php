<?php
    include('database.php');
    if(isset($_GET['token'])){
        $token = $_GET['token'];
        $select_token = "SELECT token from users WHERE token = '$token'";
        $mysqli_select_token_query = mysqli_query($conn, $select_token);
        if(mysqli_num_rows($mysqli_select_token_query)==1){
            $update_account_status = "UPDATE users SET account_status = 'active'";
            $mysqli_update_account_status_query = mysqli_query($conn, $update_account_status);
            if($mysqli_update_account_status_query){
                session_start();
                $_SESSION['login_notice'] = "<p>Your account is activated. Please proceed to login.</p>";
                header("location: login.php");
            }else{
                echo "There was some error in redirecting to login page!";
            }
        }else{
            echo "Token is invalid!";
        }
    }else{
        echo "Invalid verification link!";
    }
?>