<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        include_once("links.php");
        include_once("database.php");
        
        if(!isset($_SESSION)){
            session_start();
        }
    ?>
    <!-- Place the first <script> tag in your HTML's <head> -->
    <script src="https://cdn.tiny.cloud/1/API-KEY/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <title>CREATE BLOG</title>
</head>
<body>
    <?php
        include_once("tinyMCE.php");
        if(isset($_SESSION['username']) && isset($_SESSION['password'])){
            include_once("header.php");
        }else{
            // include_once("logout_header.php");
            header("Location: login.php");
        } 
    ?>
    <div class="main_alike_with_styling">
        <div class="full_width_form">
            <?php
                if(isset($_POST['create'])){
                    $title = $_POST['title'];
                    $slug = $_POST['slug'];
                    $content = $_POST['content'];
                    $featured_image = $_FILES['featured_image']['name'];
                    $featured_image_tmp_name = $_FILES['featured_image']['tmp_name'];
                    $featured_image_destination = "upload/".$featured_image;
                    move_uploaded_file($featured_image_tmp_name, $featured_image_destination);
                    $author = $_POST['author'];
                    $published_at = $_POST['published_at'];
                    $insert = "INSERT INTO blogs (title, slug, content, featured_image, author, published_at) VALUES ('$title', '$slug', '$content', '$featured_image_destination', '$author', '$published_at')";
                    $mysqli_insert_query = mysqli_query($conn, $insert);
                    if($mysqli_insert_query){
                        echo "<p style='color:green'>Post published!</p><br>";
                    }else{
                        echo "<p style='color:red'>Could not publish post!</p><br>";
                    }
                }
            ?>
            <h1>POST A BLOG</h1><br>
            <form action="<?php echo htmlentities($_SERVER['REQUEST_URI']) ?>" method="post" enctype="multipart/form-data">
                <div class="left_panel">
                    <label for="title">TITLE</label><br>
                    <input placeholder="YOUR POST'S TITLE HERE" id="title" type="text" name="title" required><br><br>
                    <label for="slug">SLUG</label><br>
                    <input placeholder="YOUR POST'S URL HERE" id="slug" type="text"  name="slug" required><br><br>
                    <label for="content">CONTENT</label><br>
                    <textarea id="content" placeholder="YOUR POST'S CONTENT HERE" name="content"></textarea><br><br>
                    <button type="submit" name="create">CREATE</button>
                    <button type="submit" name="cancel">CANCEL</button>
                </div>
                <div class="right_panel">
                    <label for="featured_image">FEATURED IMAGE</label><br>
                    <input placeholder="YOUR POST'S FEATURED IMAGE HERE" id="featured_image" type="file" name="featured_image" ><br><br>
                    <label for="author">AUHTOR</label><br>
                    <select name="author" id="author" required>
                        <option value="<?php echo $_SESSION['username'] ?>" selected><?php echo $_SESSION['username'] ?></option>
                    </select><br><br>
                    <label for="published_at">PUBLISHED AT</label><br>
                    <input placeholder="YOUR POST'S PUBLISHED DATE & TIME" id="published_at" value="<?php date_default_timezone_set("asia/kolkata"); echo date("Y-m-d");?>" type="date" name="published_at"><br><br>
                </div>
            </form>
        </div>
    </div>
    <script>
        //TITLE TO SLUG CONVERSION
        let title = document.querySelector("#title");
        let slug = document.querySelector("#slug");
        title.addEventListener("change", function(event){
            let title_value = event.target.value;
            let slug_value = title_value.split(" ").join("-");
            slug.value = slug_value.toLowerCase();
        })
    </script>
    <?php include_once("footer.php") ?>
    <button class="scroll_to_top"><i class="fa-solid fa-angle-up"></i></button>
</body>
</html>
