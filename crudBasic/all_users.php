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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("links.php") ?>
    <title>All Users</title>
</head>
<body>
    <?php include_once("header.php");?>
    
    <div class="main">
        <table>
            <caption>ALL USERS</caption>
            <tr>
                <th>PHOTO</th>
                <th>USER ID</th>
                <th>USERNAME</th>
                <th>FULL NAME</th>
                <th>EMAIL</th>
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
                            // $half_email = explode("@", $row['email'])[0];
                            // print_r($half_email);
                            echo "<tr>
                                    <td><img style='border-radius: 50%' width='50px' src={$row['pic']}></td>
                                    <td>{$row['id']}</td>
                                    <td>{$row['username']}</td>
                                    <td>{$row['full_name']}</td>
                                    <td>{$row['email']}</td>
                                    <td hidden>{$row['password']}</td>
                                    <td>{$row['online_status']}</td>
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
                                            <input type='password' id='password' name='password' placeholder='NEW PASSWORD'><br>
                                            <input type='submit' name='update_new_password' value='UPDATE PASSWORD'>
                                        </form>
                                </div>";
                        }
                        if(isset($_POST['update_new_password'])){
                            $id = $_POST['id'];
                            $pass = $_POST['password'];
                            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                            $update = "UPDATE users SET password = '$password' WHERE id = '$id'";
                            // var_dump($password, $id);

                            $mysqli_update = mysqli_query($conn, $update);
                            if($mysqli_update){
                                echo "<p style='color:green; position:absolute; top:0'>Password Updated!</p>";
                                $_SESSION['password'] = $pass;
                                echo "<script>setTimeout(function(){return location.href = location.href}, 2000)</script>";
                            }else{
                                echo "<p style='color:red;'>Could not update the password!</p>";
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
    <?php include_once("footer.php") ?>
</body>
</html>