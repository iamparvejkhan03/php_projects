<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        include_once("links.php");
        include_once("database.php");
        include_once("date_difference.php");
        date_default_timezone_set("Asia/Kolkata");
        // session_start();
        // $_SESSION['last_seen'] = date("Y-m-d H:i:s");
        $slug =null;
        if(isset($_GET['slug'])){
            $slug = $_GET['slug'];
        }
        $current_url =  $_SERVER['REQUEST_URI'];
        $order_by = 'DESC';
        $like_count = 0;
        $dislike_count = 0;
        $reply_count = 0;
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
        $_SESSION['last_seen'] = date("Y-m-d H:i:s");
    ?>
    <div class="main_alike_with_styling">
        <button class="post_a_blog_view" name="post_a_blog" onclick="location.href = 'post_blog.php'">POST A BLOG</button>
        <div class="full_width_form full_width_section">
            <div class="right_panel view_post_right_panel">
                <div class="search_box form">
                    <h3>SEARCH HERE!</h3><br>
                    <form action="search.php" method="get">
                        <input type="search" placeholder="SEARCH HERE" name="search" id="" required><br>
                        <button class="full_width_button">SEARCH <i class='fa fa-search'></i></button>
                    </form>
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
                                <div class='blog_text'>{$rows['content']}</div><br><br><br>
                                </div>
                            </div>
                        ";
                    }
                }else{
                    echo "<p style='color:red;'>Could not show blogs!</p>";
                }
            ?>
            <div class="comment_form left_panel form">
                <?php
                    if(isset($_POST['add_comment'])){
                        $full_name = $_POST['full_name'];
                        $email = $_POST['email'];
                        $comment = $_POST['comment'];
                        $insert = "INSERT INTO comments (full_name, email, comment, slug) VALUES ('$full_name', '$email', '$comment', '$slug')";
                        $mysqli_insert_query = mysqli_query($conn, $insert);
                        if($mysqli_insert_query){
                            echo "<p style='color:green'>Comment added!</p>";
                        }else{
                            echo "<p style='color:red'>Comment failed!</p>";
                        }
                    }
                ?>
                <h3>SHARE YOUR THOUGHTS ABOUT THIS POST!</h3><br>
                <form method="post" action="<?php echo htmlentities($_SERVER['REQUEST_URI']) ?>">
                    <input type="text" name="full_name" placeholder="FULL NAME" required>
                    <input type="email" name="email" placeholder="E-MAIL ADDRESS"><br><br>
                    <textarea name="comment" placeholder="YOUR COMMENT GOES HERE"></textarea><br><br>
                    <button class="full_width_button" name="add_comment">ADD COMMENT</button>
                </form>
            </div><br><br>

            <h2 id="comment_heading">COMMENTS</h2><br>
            <div class="comment_box left_panel">
                <?php
                    $select = "SELECT * FROM comments WHERE slug = '$slug' ORDER BY id $order_by";
                    $mysqli_select_query = mysqli_query($conn, $select);
                    if(mysqli_num_rows($mysqli_select_query)>0){
                        while($rows = mysqli_fetch_assoc($mysqli_select_query)){
                            // print_r($rows);
                            $date = $rows['date'];
                            $date_comment = date_difference($date);
                            echo "
                                <div class='single_comment_box'>
                                    <img src='https://cdn-icons-png.flaticon.com/512/149/149071.png' alt='commentor_image'>
                                    <div class='card_author_info'>
                                        <div class='commentor_name_date'>
                                            <h5>{$rows['full_name']}</h5>
                                            <p>{$date_comment}</p>
                                        </div><br>
                                        <p>{$rows['comment']}</p><br>
                                        <div class='commentor_name_date'>
                                            <button><i class='fa-regular fa-thumbs-up like{$rows['id']}'></i> LIKE</button>
                                            <button><i class='fa-regular fa-thumbs-down dislike{$rows['id']}'></i> DISLIKE</button>
                                            <button><i class='fa-regular fa-comment reply{$rows['id']}'></i> REPLY</button>
                                        </div>
                                        <script>
                                            let like_button{$rows['id']} = document.querySelector('.like{$rows['id']}');
                                            let dislike_button{$rows['id']} = document.querySelector('.dislike{$rows['id']}');
                                            let reply_button{$rows['id']} = document.querySelector('.reply{$rows['id']}');
                                            let like_count{$rows['id']} = 0;
                                            let dislike_count{$rows['id']} = 0;
                                            let reply_count{$rows['id']} = 0;
                                            function solid_bg(button, count){
                                                button.addEventListener('click', function(){
                                                    button.classList.toggle('fa-solid');
                                                    count++;
                                                    if(like_button{$rows['id']}.classList.contains('fa-solid')){
                                                        dislike_button{$rows['id']}.classList.toggle('fa-regular');
                                                    }
                                                    if(dislike_button{$rows['id']}.classList.contains('fa-solid')){
                                                        like_button{$rows['id']}.classList.toggle('fa-regular');
                                                    }
                                                })
                                            }
                                            solid_bg(like_button{$rows['id']}, like_count{$rows['id']});
                                            solid_bg(dislike_button{$rows['id']}, dislike_count{$rows['id']});
                                            solid_bg(reply_button{$rows['id']}, reply_count{$rows['id']});
                                        </script>
                                    </div>
                                </div><br><br>";
                        }
                    }else{
                        echo "No comments yet!";
                    }
                ?>
                
            </div><br><br>
            <h2>RELATED POSTS</h2><br>
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
    <?php include_once("footer.php") ?>
    <button class="scroll_to_top"><i class="fa-solid fa-angle-up"></i></button>
</body>
</html>