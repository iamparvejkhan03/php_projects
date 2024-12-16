<?php
    include("database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("links.php") ?>
    <title>Website</title>
</head>
<body>
    <div id="main">
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
            <div class="buttons">
                <button class="login_button"><a href="login.php">Login</a></button>
                <button class="register_button"><a href="register.php">Register</a></button>
            </div>
        </div>
        <div id="hero">
            <div class="hero_content">
                <h1>WELCOME TO MY WEBSITE!</h1><br>
                <h3>THIS IS A WEBSITE DESIGNED BY PARVEJ KHAN. I WELCOME YOU ALL TO USE IT.</h3><br>
                <p><a href="download.php?file=upload/cn">DOWNLOAD OUR PDF</a></p><br>
                <p><a href="download.php">DOWNLOAD OUR IMAGE</a></p>
            </div>
        </div>
    </div>
</body>
</html>