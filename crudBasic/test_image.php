<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if(isset($_SESSION['datetime'])){
        var_dump($_SESSION['datetime']);
        date_default_timezone_set("asia/kolkata");
        echo date("Y-m-d h:i:s");
    } ?>
    <form action="test_image.php" method="post" enctype="multipart/form-data">
        <!-- <label for="photo">UPLOAD IMAGE:</label><br><br>
        <input type="file" name="photo" id="photo"><br><br> -->
        <label for="datetime">DATETIME:</label><br><br>
        <input type="datetime-local" name="datetime" value="<?php date_default_timezone_set("asia/kolkata"); $date = date("Y-m-d"); $time = date("h:i:s"); echo $date.'T'.$time?>" id="datetime"><br><br>
        <input type="submit" name="submit" value="SUBMIT">
    </form>
</body>
</html>

<?php
    $photo = null;
    $tmp_name = null;
    $destination = null;
    // if(isset($_POST['submit'])){
    //     $_SESSION['photo'] = $_FILES['photo'];
    //     $photo = $_SESSION['photo'];
    //     $tmp_name = $_FILES['photo']['tmp_name'];
    //     $destination = "upload/ {$_FILES['photo']['name']}";
    //     move_uploaded_file($tmp_name, $destination);
    // }

    // if(isset($_SESSION['photo'])){
    //     print_r($photo);
    // }

    if(isset($_POST['submit'])){
        $datetime = $_POST['datetime'];
        $_SESSION['datetime'] = $datetime;
    }
?>