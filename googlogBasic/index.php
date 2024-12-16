<?php
    // include_once("config.php");
    // if (!isset($_GET['code'])) {
    //     $authUrl = $google_client->createAuthUrl();
    //     header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    // } else {
    //     $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);
    //     $tokenData = $google_client->verifyIdToken();
    //     $google_client->setAccessToken($token['access_token']);
    //     print_r($tokenData) . "<br>"; // Contains user data like email, name, etc.
    //     session_start();
    //     $_SESSION['email'] = $tokenData['email'];
    //     echo $_SESSION['email'];
    // }
    // echo $_SESSION['email'];
?>

<?php
    //Include Configuration File
    include('config.php');
    session_start();

    $login_button = '';

    if(isset($_GET["code"])){
        $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
        if(!isset($token['error'])){
            $google_client->setAccessToken($token['access_token']);        
            $_SESSION['access_token'] = $token['access_token'];
            $google_service = new Google_Service_Oauth2($google_client);
            $data = $google_service->userinfo->get();

            foreach($data as $key =>$value){
              // foreach($obj as $key => $value){
                echo "{$key} = {$value}<br>";
              }
            // }

            if(!empty($data['given_name'])){
                $_SESSION['user_first_name'] = $data['given_name'];
            }

            if(!empty($data['id'])){
              $_SESSION['id'] = $data['id'];
          }

            if(!empty($data['family_name'])){
                $_SESSION['user_last_name'] = $data['family_name'];
            }

            if(!empty($data['email'])){
                $_SESSION['user_email_address'] = $data['email'];
            }

            if(!empty($data['gender'])){
                $_SESSION['user_gender'] = $data['gender'];
            }else{
              $_SESSION['user_gender'] = "No gender set";
            }

            if(!empty($data['picture'])){
                $_SESSION['user_image'] = $data['picture'];
            }
        }
    }

    if(!isset($_SESSION['access_token'])){
        // $login_button = '<a href="'.$google_client->createAuthUrl().'">Login With Google</a>';
        header("Location: login.php");
    }
    if(isset($_SESSION['user_first_name'])){
      echo $_SESSION['user_first_name']."<br>";
      echo $_SESSION['user_last_name']."<br>";
      echo $_SESSION['user_email_address']."<br>";
      echo $_SESSION['user_gender']."<br>";
      echo $_SESSION['id']."<br>";
    }
    // echo $_SESSION['user_last_name'];
    // echo $_SESSION['user_email_address'];
    // echo $_SESSION['user_image'];
    // echo $_SESSION['user_gender'];
    // session_destroy();
?>