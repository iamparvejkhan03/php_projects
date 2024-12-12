<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Happy+Monkey&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div id="main">
        <?php
            if(isset($_POST['flip'])){
                $random_number = rand(1,2);
                $side = $_POST['side'];
                if($random_number == $side){
                    echo "<h1>You win!</h1>";
                }else{
                    echo "<h1>You lose. Better luck next time!</h1>";
                }
            }
        ?>
        <div id="flip_a_coin">
            <div class="heading_container">
                <h1>FLIP A</h1>
                <h1>COIN</h1>
            </div>
            <form action="index.php" method="post">
                <select name="side">
                    <option value="1">HEADS</option>
                    <option value="2">TAILS</option>
                </select><br><br>
                <input type="submit" name="flip" value="FLIP">
            </form>
        </div>
        
    </div>
</body>
</html>
