<?php
    include("database.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("links.php") ?>
    <title>Website</title>
</head>
<body>
    <?php if(isset($_SESSION['username']) && isset($_SESSION['password'])){
        include_once("header.php");
    }else{
        include_once("logout_header.php");
    } ?>
    <div class="main">
            <div class="form">
                <h1>WELCOME TO MY WEBSITE!</h1><br>
                <h3>THIS IS A WEBSITE DESIGNED BY PARVEJ KHAN. I WELCOME YOU ALL TO USE IT.</h3><br>
                <p><a href="download.php?file=upload/cn">DOWNLOAD OUR PDF</a></p><br>
                <p><a href="download.php">DOWNLOAD OUR IMAGE</a></p>
            </div>
    </div>
</body>
</html>