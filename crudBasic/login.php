<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Happy+Monkey&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="form_container">
        <div id="login_form">
            <h2>LOGIN NOW!</h2><br><br>
            <form action="login.php" method="post">
                <input type="email" name="email" placeholder="EMAIL ADDRESS"><br><br>
                <input type="password" name="password" placeholder="PASSWORD"><br><br>
                <input type="submit" name="login" value="LOGIN">
            </form><br>
            <p>NOT REGSITERED YET? <a href="register.php">SIGN UP NOW</a></p>
        </div>
    </div>
</body>
</html>