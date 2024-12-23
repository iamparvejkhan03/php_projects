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
    <title>SEARCH</title>
</head>
<body>
    <?php 
        if(isset($_SESSION['username']) && isset($_SESSION['password'])){
            include_once("header.php");
        }else{
            include_once("logout_header.php");
        } 
        $search = null;
        if(isset($_GET['search'])){
            $search = $_GET['search'];
        }
    ?>
    <div class="main_alike_with_styling">
        <button name="post_a_blog_search" onclick="location.href = 'post_blog.php'">POST A BLOG</button>
            <div class="full_width_search_box">
                <form action="search.php" method="get">
                    <input type="search" placeholder="SEARCH HERE" name="search" id="" required>
                    <button class="search_button">SEARCH <i class='fa fa-search'></i></button>
                </form>
        </div>
        <h2>SEARCHED RESULTS</h2><br>
        <div class="main cards_in_row">
        <?php
            $select = "SELECT * FROM blogs WHERE title LIKE '%$search%' OR author LIKE '%$search%' OR content LIKE '%$search%'";
            $mysqli_select_query = mysqli_query($conn, $select);
            if(mysqli_num_rows($mysqli_select_query)>0){
                while($rows = mysqli_fetch_assoc($mysqli_select_query)){
                    // print_r($rows);
                    $content = $rows['content'];
                    $para = explode('<p>', $content)[1];
                    $author = $rows['author'];
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
                                        <p>{$rows['published_at']}</p>
                                    </div>
                                </div><br>
                                <h4><a target='_blank' href='view_post.php?slug={$rows['slug']}'>{$rows['title']}</a></h4><br>
                                <p>{$para}</p><br>
                            </div>
                        </div>
                    ";
                }
            }else{
                echo "<h2 style='color:red; text-align:center'>No post or author found!</h2>";
            }
    ?>
        </div>
    </div>
    <?php include_once("footer.php") ?>
    <button class="scroll_to_top"><i class="fa-solid fa-angle-up"></i></button>
</body>
</html>