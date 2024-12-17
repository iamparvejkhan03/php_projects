<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        include_once("links.php");
        include_once("database.php");
        session_start();
        $slug =null;
        if(isset($_GET['slug'])){
            $slug = $_GET['slug'];
        }
    ?>
    <script src="https://cdn.tiny.cloud/1/d74ps4pecw18bu9j3qvz6b8mes2471bg7pzc6bq61ar9zm9f/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <title>VIEW POST</title>
</head>
<body>
    <?php 
        include_once("tinyMCE.php");
        if(isset($_SESSION['username']) && isset($_SESSION['password'])){
            include_once("header.php");
        }else{
            include_once("logout_header.php");
        } 
    ?>
    <div class="main_alike_with_styling">
        <button name="post_a_blog" onclick="location.href = 'post_blog.php'">POST A BLOG</button>
        <div class="full_width_form full_width_section">
            <div class="right_panel">
                <h2>SEARCH HERE!</h2><br>
                <div class="search_box form">
                    <input type="search" placeholder="SEARCH HERE" name="search" id=""><br><br>
                    <button class="full_width_button">SEARCH <i class='fa fa-search'></i></button>
                </div>
            </div>
            <?php 
                $author = null;
                $select = "SELECT * FROM blogs WHERE slug = '$slug'";
                $mysqli_select_query = mysqli_query($conn, $select);
                if($mysqli_select_query){
                    $author_pic = null;
                    while($rows = mysqli_fetch_assoc($mysqli_select_query)){
                        $author = $rows['author'];
                        $_SESSION['author'] = $author;
                        $date = date_create($rows['published_at']);
                        $published_at = date_format($date, "M d, Y");
                        $select_pic = "SELECT pic FROM users WHERE username = '$author'";
                        $mysqli_select_pic_query = mysqli_query($conn, $select_pic);
                        while($cols = mysqli_fetch_assoc($mysqli_select_pic_query)){
                            $author_pic = ($cols['pic']);
                        }
                        echo "
                            <div class='left_panel blog_content'>
                                <h1>{$rows['title']}</h1><br>
                                <div class='card_author_info'>
                                    <img width='50px' height='50px' style='border-radius: 50%' src='{$author_pic}' alt='author Image'>
                                    <h4>{$rows['author']}</h4>
                                    <p>{$published_at}</p>
                                </div><br>
                                <img width='100%' style='border-radius:20px;' src='{$rows['featured_image']}' alt='featured_img'><br><br>
                                <div class='blog_text'>{$rows['content']}</div><br>
                                </div>
                            </div>
                        ";
                    }
                }else{
                    echo "<p style='color:red;'>Could not show blogs!</p>";
                }
            ?>
            <div class="comment_form left_panel form">
                <h2>SHARE YOUR THOUGHTS ABOUT THIS POST!</h2><br>
                <form method="post" action="<?php echo htmlentities($_SERVER['REQUEST_URI']) ?>">
                    <input type="text" name="full_name" placeholder="FULL NAME" required>
                    <input type="email" name="email" placeholder="E-MAIL ADDRESS"><br><br>
                    <textarea name="comment" placeholder="YOUR COMMENT GOES HERE"></textarea><br><br>
                    <button class="full_width_button" name="add_comment">ADD COMMENT</button>
                </form>
            </div><br><br>

            <div class='cards_in_row'>
                <?php 
                    $select = "SELECT * FROM blogs WHERE author = '$author'";
                    $mysqli_select_query = mysqli_query($conn, $select);
                    if($mysqli_select_query){
                        $author_pic = null;
                        while($rows = mysqli_fetch_assoc($mysqli_select_query)){   
                            $content = $rows['content'];
                            $para = explode('<p>', $content)[1];
                            $author = $rows['author'];
                            $date = date_create($rows['published_at']);
                            $published_at = date_format($date, "M d, Y");
                            $select_pic = "SELECT pic FROM users WHERE username = '$author'";
                            $mysqli_select_pic_query = mysqli_query($conn, $select_pic);
                            while($cols = mysqli_fetch_assoc($mysqli_select_pic_query)){
                                $author_pic = ($cols['pic']);
                            }
                            echo "
                                <div class='card'>
                                    <img width='100%' height='200px' src='{$rows['featured_image']}' alt='featured_img'><br><br>
                                    <div class='card_info'>
                                        <div class='card_author_info'>
                                            <img src='{$author_pic}' alt='author Image'>
                                            <div class='card_author_name_date'>
                                                <h5>{$rows['author']}</h5>
                                                <p>{$published_at}</p>
                                            </div>
                                        </div><br>
                                        <h4><a target='_blank' href='view_post.php?slug={$rows['slug']}'>{$rows['title']}</a></h4><br>
                                    <p>{$para}</p><br>
                                    </div>
                                </div>
                            ";
                        }
                    }else{
                        echo "<p style='color:red;'>Could not show blogs!</p>";
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>