<?php
    include("database.php");
    include("send_email.php");
    session_start();
    $session_username = $_SESSION['username'];
    if(isset($session_username)){
        $select = "SELECT * from users WHERE username='$session_username'";
        $mysqli_select_query = mysqli_query($conn, $select);
        if(mysqli_num_rows($mysqli_select_query)>0){
            $email = $rows['email'];
            $full_name = null;
            $token = null;
            $activation_url = null;
            while($rows = mysqli_fetch_assoc($mysqli_select_query)){
                // print_r($rows);
                $email = $rows['email'];
                $full_name = $rows['full_name'];
                $token = $rows['token'];
                $activation_url = "http://localhost/projects/php_projects/crudBasic/account_activation.php?token={$token}";
                // echo $email, $full_name, $token, $activation_url;
            }
            send_email($email, $full_name, $activation_url);
        }
    }else{
        echo "Try to put your login details in login form!";
    }
?>