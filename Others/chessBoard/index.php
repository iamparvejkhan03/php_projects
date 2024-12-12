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
        <form action="index.php" method="post">
            <input type="number" placeholder="NO. OF SQUARES" name="squares" id="squares"><br><br>
            <input type="submit" name="generate" value="GENERATE">
        </form>
    </div>
</body>
</html>

<?php
    if(isset($_POST['generate'])){
        $num = $_POST['squares'];
        for($row=1; $row<=$num; $row++){
            echo "<table style='border: 1px solid black; position: relative; left: 50%; transform: translate(-50%, -50%);  border-collapse:collapse;'><tr>";
            for($col=$row; $col<=($num+$row-1); $col++){
                if($col%2==0){
                    echo "<td style='border: 1px solid black; padding: 25px 25px; background-color: black;'></td>";
                }else{
                    echo "<td style='border: 1px solid black; padding: 25px 25px'></td>";
                }
            }
            echo "</tr></table>";
        }
    }
?>

<!-- $num = 5;
    for($num1=1; $num1<=$num; $num1++){
        if($num1%2==0){
            echo "<div style='display: inline-block;  box-sizing: border-box; border: 1px solid black; padding: 20px; background-color: white'> </div>";
        }else{
            echo "<div style='display: inline-block; padding: 20px; border: 1px solid black; background-color: black'> </div>";
        }
        for($num2=$num1; $num2<($num+$num1-1); $num2++){
            if($num2%2==0){
                echo "<div style='display: inline-block; padding: 20px; border: 1px solid black; background-color: black'> </div>";
            }else{
                echo "<div style='display: inline-block;  box-sizing: border-box; border: 1px solid black; padding: 20px; background-color: white'> </div>";
            }
        }
        echo "<br>";
    } -->