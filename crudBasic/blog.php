<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        include_once("links.php");
        include_once("database.php");
        session_start();
    ?>
    <title>BLOG</title>
</head>
<body>
    <?php 
        if(isset($_SESSION['username']) && isset($_SESSION['password'])){
            include_once("header.php");
        }else{
            include_once("logout_header.php");
        } 
    ?>
    <div class="main_alike_with_styling">
        <button name="post_a_blog" onclick="location.href = 'post_blog.php'">POST A BLOG</button>
        <div class="main">
        <?php 
            $domain_name = $_SERVER['REQUEST_URI'];
            $select = "SELECT * FROM blogs";
            $mysqli_select_query = mysqli_query($conn, $select);
            if($mysqli_select_query){
                // print_r($mysqli_select_query);
                $select_pic = "SELECT pic FROM users WHERE username = ''";
                $author_pic = null;
                while($rows = mysqli_fetch_assoc($mysqli_select_query)){
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
                echo "<p style='color:red;'>Could not show blogs!</p>";
            }
        ?>
        </div>
    </div>
</body>
</html>