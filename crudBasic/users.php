<?php
    include("database.php");
    $session = session_start();
    if(!isset($_SESSION['username'])){
        ?>
            <script>
                location.href = "login.php";
            </script>
        <?php
    }
    if(isset($_POST['logout'])){
        session_destroy();
        header("Location: index.php");
    }
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
    <title>All Users</title>
</head>
<body>
    <div id="header">
        <h1><a href="index.php">Logo</a></h1>
        <div id="navbar">
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="#">ABOUT</a></li>
                <li><a href="#">CONTACT</a></li>
                <li><a href="users.php">ALL USERS</a></li>
            </ul>
        </div>
        <div class="username_in_header">
            <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" height="50px" width="50px" alt="user_img">
            <a href="#"><?php 
                try{
                    echo $_SESSION['username'];
                }catch(error){
                    echo "Error occured!";
                }
            ?></a>
            <form action="users.php" method="post">
                <input type="submit" name="logout" value="LOG OUT">
            </form>
        </div>
    </div>
    
    <div id="all_users_container">
        <table>
            <caption>ALL USERS</caption>
            <tr>
                <th>USER ID</th>
                <th>USERNAME</th>
                <th>FULL NAME</th>
                <th>EMAIL</th>
                <th>TOKEN</th>
                <th>STATUS</th>
                <th>UPDATE</th>
                <th>DELETE</th>
            </tr>
            <?php
                if($session){
                    $select = "SELECT * FROM users";
                    $mysqli_select = mysqli_query($conn, $select);
                    if($mysqli_select){
                        $id = '44';
                        while($row = mysqli_fetch_assoc($mysqli_select)){
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['username']}</td>
                                    <td>{$row['full_name']}</td>
                                    <td>{$row['email']}</td>
                                    <td hidden>{$row['password']}</td>
                                    <td>{$row['token']}</td>
                                    <td>{$row['account_status']}</td>
                                    <td>
                                        <form action='users.php' method='post'>
                                            <input type='hidden' name='id' value='{$row['id']}'>
                                            <input type='submit' name='update' value='✏️'>
                                        </form>
                                    </td>
                                    <td>
                                        <form action='users.php' method='post'>
                                            <input type='hidden' name='id' value='{$row['id']}'>
                                            <input type='submit' name='delete' value='❌'>
                                        </form>
                                    </td>
                                </tr>";
                            
                        }
                        if(isset($_POST['update'])){
                            $id = $_POST['id'];
                            echo "<div id='update_password_form'>
                                        <form action='users.php' method='post'>
                                            <label for='password'>NEW PASSWORD:</label><br>
                                            <input type='hidden' name='id' value='$id'>
                                            <input type='password' id='password' name='password'><br>
                                            <input type='submit' name='update_new_password' value='UPDATE PASSWORD'>
                                        </form>
                                </div>";
                        }
                        if(isset($_POST['update_new_password'])){
                            $id = $_POST['id'];
                            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                            $update = "UPDATE users SET password = '$password' WHERE id = '$id'";
                            // var_dump($password, $id);

                            $mysqli_update = mysqli_query($conn, $update);
                            if($mysqli_update){
                                echo "Password Updated!";
                            }else{
                                echo "Could not update the password!";
                            }
                        }
                        if(isset($_POST['delete'])){
                            $id = $_POST['id'];
                            $select_user_based_on_id = "SELECT username FROM users WHERE id = '$id'";
                            $mysqli_select_user_based_on_id_query = mysqli_query($conn, $select_user_based_on_id);
                            $current_username = null;
                            while($rows = mysqli_fetch_assoc($mysqli_select_user_based_on_id_query)){
                                $current_username = $rows['username'];
                            }

                            if($mysqli_select_user_based_on_id_query && $_SESSION['username'] == $current_username){
                                echo "<p style='color:red; position:absolute;'>Can't delete yourself!</p>";
                            }else{
                                $delete = "DELETE FROM users WHERE id = '$id'";
                                $mysqli_delete = mysqli_query($conn, $delete);
                                if($mysqli_delete){
                                    echo "<p style='color:green; position:absolute;'>User deleted!</p>";
                                    ?>
                                       <script>
                                            location.href = location.href;
                                            exit();
                                        </script>
                                   <?php
                                }
                            }
                        }
                    }else{
                        echo "Query failed: ". mysqli_error($conn);
                    }
                }
            ?>
        </table>
    </div>
</body>
</html>