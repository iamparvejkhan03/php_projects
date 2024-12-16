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
    <form action="test_image.php" method="post" enctype="multipart/form-data">
        <label for="photo">UPLOAD IMAGE:</label><br><br>
        <input type="file" name="photo" id="photo"><br><br>
        <input type="submit" name="submit" value="SUBMIT">
    </form>
</body>
</html>

<?php
    $photo = null;
    $tmp_name = null;
    $destination = null;
    if(isset($_POST['submit'])){
        $_SESSION['photo'] = $_FILES['photo'];
        $photo = $_SESSION['photo'];
        $tmp_name = $_FILES['photo']['tmp_name'];
        $destination = "upload/ {$_FILES['photo']['name']}";
        move_uploaded_file($tmp_name, $destination);
    }

    if(isset($_SESSION['photo'])){
        print_r($photo);
    }
?>