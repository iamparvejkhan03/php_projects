<?php
    include("database.php");
    $session = session_start();

    if(!isset($_SESSION['username'])){
        ?>
            <script>
                location.href = "login.php";
            </script>
        <?php
    }else{
        $username = $_SESSION['username'];
    }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("links.php") ?>
    <title>All Users</title>
    <script>
        // let start_chat_button = document.querySelector(".start_chat_button");
        //     start_chat_button.addEventListener("click", function(){
        //         location.href = "chat.php";
        //     })
        function start_chat_button(id){
                // location.href = `chat.php?id=${id}`;
                location.href = `websocket_chat.php?id=${id}`;
            }
    </script>
</head>
<body>
    <?php include_once("header.php");?>
    
    <div class="main">
        <table>
            <caption>ONLINE USERS</caption>
            <tr>
                <th>PHOTO</th>
                <th>USERNAME</th>
                <th>FULL NAME</th>
                <th>ONLINE STATUS</th>
            </tr>
            <?php
                if($session){
                    $select = "SELECT * FROM users WHERE online_status = 'online' AND username != '$username'";
                    $mysqli_select = mysqli_query($conn, $select);
                    if($mysqli_select){
                        while($row = mysqli_fetch_assoc($mysqli_select)){
                            // $half_email = explode("@", $row['email'])[0];
                            // print_r($half_email);
                            $id = $row['id'];
                            echo "<tr>
                                    <td><img style='border-radius: 50%' width='50px' src={$row['pic']}><i class='online_status_icon fa-solid fa-circle'></i></td>
                                    <td>{$row['username']}</td>
                                    <td>{$row['full_name']}</td>
                                    <td>{$row['online_status']}</td>
                                    <td><button onclick='start_chat_button($id)' class='start_chat_button' type='button'>CHAT <i class='fa-brands fa-rocketchat'></i></button></td>
                                </tr>";
                        }
                    }else{
                        echo "Query failed: ". mysqli_error($conn);
                    }
                }
            ?>
        </table>
    </div>
    <?php include_once("footer.php") ?>
    <button class="scroll_to_top"><i class="fa-solid fa-angle-up"></i></button>
</body>
</html>