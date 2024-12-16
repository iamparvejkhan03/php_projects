<?php
    //Include Configuration File
    include_once('google_client.php');
    include_once('database.php');
    include_once("send_email.php");
    session_start();

    $first_name = null;
    $last_name = null;
    $full_name = null;
    $username = null;
    $email = null;
    $password = null;
    $pic = null;
    $hash_password = null;
    $token = null;

    if(isset($_GET["code"])){
        $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
        if(!isset($token['error'])){
            $google_client->setAccessToken($token['access_token']);        
            $_SESSION['access_token'] = $token['access_token'];
            $google_service = new Google_Service_Oauth2($google_client);
            $data = $google_service->userinfo->get();

            if(!empty($data['given_name'])){
                $_SESSION['first_name'] = $data['given_name'];
            }

            if(!empty($data['id'])){
              $_SESSION['id'] = $data['id'];
          }

            if(!empty($data['family_name'])){
                $_SESSION['last_name'] = $data['family_name'];
            }

            if(!empty($data['email'])){
                $_SESSION['email'] = $data['email'];
            }

            if(!empty($data['picture'])){
                $_SESSION['pic'] = $data['picture'];
            }
        }
    }

    if(!isset($_SESSION['access_token'])){
        header("Location: login.php");
    }
    
    if(isset($_SESSION['first_name'])){
        $first_name = $_SESSION['first_name'];
    }
    if(isset($_SESSION['last_name'])){
        $last_name = $_SESSION['last_name'];
    }
    if(isset($_SESSION['first_name']) || isset($_SESSION['last_name'])){
        $full_name = $_SESSION['first_name'] . " " .$_SESSION['last_name'];
        $_SESSION['full_name'] = $full_name;
    }
    if(isset($_SESSION['email'])){
        $email = $_SESSION['email'];
        $username = explode("@", $email)[0];
        $_SESSION['username'] = $username;
    }
    if(isset($_SESSION['id'])){
        $password = $_SESSION['id'];
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        $_SESSION['password'] = $password;
    }
    if(isset($_SESSION['pic'])){
        $pic = $_SESSION['pic'];
    }
    $token = bin2hex(random_bytes(15));
    $activation_url = "http://localhost/projects/php_projects/crudBasic/account_activation.php?token={$token}";
    $select = "SELECT * FROM users WHERE email = '$email'";
    $mysqli_select_query = mysqli_query($conn, $select);
    setcookie("username", "{$username}", (time()+86400*30));
    setcookie("password", "{$password}", (time()+86400*30));
    if(mysqli_num_rows($mysqli_select_query)>0){
        // echo "<h2 style='text-align: center; color:red'>Already registered with this account. Please try to login.</h2>";
        header("Location: profile.php");
    }else{
        $insert = "INSERT INTO users (full_name, username, email, password, token, account_status, pic) VALUES ('$full_name', '$username', '$email', '$hash_password', '$token', 'active', '$pic')";
        $mysqli_insert_query = mysqli_query($conn, $insert);
        if($mysqli_insert_query){
            send_email($email, $full_name, $activation_url);
            header("Location: profile.php");
        }else{
            echo "There was some error!";
        }
    }
?>