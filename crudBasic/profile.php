<?php
    include("database.php");
    include("date_difference.php");
    date_default_timezone_set("Asia/Kolkata");
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }
    $pic_destination = null;
    // $last_active = date_create();
    $last_seen = null;
    if(isset($_SESSION['last_seen'])){
        $last_seen_session = $_SESSION['last_seen'];
        $last_seen = date_difference($last_seen_session);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("links.php") ?>
    <title>User Profile</title>
</head>
<body>
    <?php include_once("header.php");?>
    <div class="main">
        <div class="form user_profile_box">
            <h3>USER PROFILE</h3><br>
            <?php
                $full_name = null;
                $username = null;
                $email = null;
                $password = null;
                $hash_password = null;
                $old_username = $_SESSION['username'];
                $id = null;
                $online_status = null;
                $tmp_name = null;
                // var_dump($old_username);
                $select = "SELECT * FROM users WHERE username = '$old_username'";
                $mysqli_select_query = mysqli_query($conn, $select);
                while($rows = mysqli_fetch_assoc($mysqli_select_query)){
                    $id = $rows['id'];
                    $_SESSION['my_id'] = $id;
                    $online_status = $rows['online_status'];
                    $pic_destination = $rows['pic'];
                    // print_r($rows);
                    // echo $id;
                }
                if(isset($_POST['update'])){
                    $full_name = $_POST['full_name'];
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    if(isset($_FILES['pic']) && $_FILES['pic']['error'] === UPLOAD_ERR_OK && ($_FILES['pic']['type']=='image/jpeg' || $_FILES['pic']['type']=='image/png' || $_FILES['pic']['type']=='image/webp')){
                        if($_FILES['pic']['size']<1024*1024){
                            $pic = $_FILES['pic'];
                            $tmp_name = $_FILES['pic']['tmp_name'];
                            $pic_name = $_FILES['pic']['name'];
                            $pic_destination = "upload/".$pic_name;
                            $_SESSION['pic'] = $pic_destination;
                            $_SESSION['pic_extension'] = $pic;
                            move_uploaded_file($tmp_name, $pic_destination);
                        }else{
                            echo "<p style='color:red;'>File size is too big!<br>Please upload an image of less than 1MB.</p>";
                            header("Refresh: 5");
                            exit;
                        }
                    }else{
                        echo "<p style='color:red;'>Unsupported file type!<br>Please upload a PNG, JPEG, or WebP image.</p>";
                        header("Refresh: 5");
                        exit;
                    }
                    $hash_password = password_hash($password, PASSWORD_DEFAULT);
                    $update = "UPDATE users SET username = '$username', full_name = '$full_name', email = '$email', password = '$hash_password', pic = '$pic_destination' WHERE id = '$id'";
                    $mysqli_update_query = mysqli_query($conn, $update);
                    if($mysqli_update_query){
                        $_SESSION['username'] = $username;
                        $_SESSION['password'] = $password;
                        $_SESSION['full_name'] = $full_name;
                        $_SESSION['email'] = $email;
                        setcookie('username', "{$username}", (time()+86400*30));
                        setcookie('password', "{$password}", (time()+86400*30));
                        // echo "<script>location.href = location.href</script>";
                        echo "<p style='color:green'>Profile Updated Successfully!</p><br>";
                        header("Refresh: 1");
                        exit;
                    }else{
                        echo "<p style='color:red'>Profile Updation Failed!</p><br>";
                    }
                }
            ?>
            <img width="100px" style="position:relative; border-radius: 50%; left: 50%; transform: translate(-50%);" src=<?php if(!empty($pic_destination)){echo $pic_destination;}else{echo "https://cdn-icons-png.flaticon.com/512/149/149071.png";} ?> alt="user_image"><br><br>
            <p style="color: lightgreen;">LAST SEEN: <?php echo strtoupper($last_seen) ?>
                <?php
                if($online_status == "online"){
                    echo "<i class='online_status_icon fa-solid fa-circle'></i>";
                }
                ?>
            </p><br>
            <form action="<?php echo htmlentities($_SERVER['REQUEST_URI'])?>" method="post" enctype="multipart/form-data">
                <!-- <button name="add_pic">ADD PIC <i class="fas fa-camera"></i></button><br><br> -->
                <input type="file" value="<?php echo $pic_destination ?>" name="pic" id="pic"><br><br>
                <input type="text" placeholder="FULL NAME" value="<?php echo $_SESSION['full_name'] ?>" name="full_name"><br><br>
                <input type="text" placeholder="USERNAME" value="<?php echo $_SESSION['username'] ?>" name="username"><br><br>
                <input type="email" placeholder="E-MAIL ADDRESS" value="<?php echo $_SESSION['email'] ?>" name="email"><br><br>
                <input type="text" placeholder="PASSWORD" value="<?php echo $_SESSION['password'] ?>" name="password"><br><br>
                <!-- <input type="submit" value="UPDATE" name="update"><br><br> -->
                <button name="update">UPDATE PROFILE <i class="fa fa-edit"></i></button><br><br>
                <button name="delete_profile">DELETE PROFILE <i class="fa fa-trash"></i></button>
            </form>
        </div>
    </div>
    <?php include_once("footer.php") ?>
    <button class="scroll_to_top"><i class="fa-solid fa-angle-up"></i></button>
</body>
</html>

<?php
    if(isset($_POST['delete_profile'])){
        $delete = "DELETE FROM users WHERE id = '$id'";
        $mysqli_delete_query = mysqli_query($conn, $delete);
        if($mysqli_delete_query){
            session_destroy();
            setcookie('username', '');
            setcookie('password', '');
            header("Location: index.php");
        }else{
            echo "Profile deletion failed!";
        }
    }
?>