<?php
    include("database.php");
    if(!isset($_SESSION)){
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        include("links.php");
    ?>
    <title>Website</title>
</head>
<body>
    <?php if(!isset($_SESSION)){
        include_once("logout_header.php");
    }else{
        include_once("header.php");
    } ?>
    <div class=" hero_section">
            <div class="form slider_content">
                <h1>HI, I'M PARVEJ KHAN</h1>
                <h3>FULL STACK DEVELOPER</h3><br>
                <p>IF YOU ARE LOOKING FOR A DEVELOPER WHO CAN CREATE A WEBSITE FROM FRONTEND TO BACKEND, THEN YOUR SEARCH ENDS HERE. MY NAME IS PARVEJ AND I WILL BE YOUR DEVELOPER. I WILL PREPARE A FIGMA DESIGN FOR YOU AND THEN CREATE EXACTLY LIKE IT PIXEL BY PIXEL.</p><br>
                <div class="download_buttons">
                    <button onclick="location.href = 'download.php?file=upload/cn'">MY DEMOS</button>
                    <button class="no_bg_button" onclick="location.href = 'download.php'">MY PRICES</button>
                </div><br>
                <div class="social_icons">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                    <a href="#"><i class="fa-brands fa-github"></i></a>
                </div>
            </div>
            <div class="hero_image_container">
            </div>
    </div>
    <button class="scroll_to_top"><i class="fa-solid fa-angle-up"></i></button>
    <?php include_once("footer.php") ?>
</body>
</html>