<?php
    include_once("links.php");
?>

<div class="header">
    <a href="index.php"><img height="50px" src="upload/logo.png" alt="logo"></a>
    <div id="navbar">
        <ul>
            <li><a href="index.php">HOME</a></li>
            <li><a href="#">ABOUT</a></li>
            <li><a href="contact.php">CONTACT</a></li>
            <li><a href="users.php">ALL USERS</a></li>
        </ul>
    </div>

    <div class="username_in_header">
        <img src=<?php if(!empty($_SESSION['pic'])){echo $_SESSION['pic'];}else{ echo "https://cdn-icons-png.flaticon.com/512/149/149071.png";}?> height="50px" width="50px" alt="user_img">
        <a href="profile.php"><?php 
            try{
                echo $_SESSION['username'];
            }catch(error){
                echo "Error occured!";
            }
        ?></a>
        <form action="users.php" method="post">
            <!-- <input type="submit" name="logout" value="LOG OUT"> -->
            <button name="logout">LOG OUT <i class="fa fa-sign-out"></i></button>
        </form>&nbsp;
        <button class="mode_btn" name="mode"><i class="fas fa-sun" aria-hidden="true"></i></button>
    </div>
</div>

<?php
    if(isset($_POST['logout'])){
        session_destroy();
        header("Location: index.php");
    }
?>