<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Happy+Monkey&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div id="main">
        <div id="calculator_box">
            <div id="calculator_title_form_container">
                <div class="calculator_heading">
                    <h1>PHP</h1>
                    <h1>CALCULATOR</h1>
                </div>
                <div id="calculator_form">
                    <form action="index.php" method="post">
                        <input type="number" name="first_number" placeholder="ENTER NUMBER"><br><br>
                        <input type="number" name="second_number" placeholder="ENTER NUMBER"><br><br>
                        <select name="arithmetic_operation">
                            <option value="select_operation" selected>Select Operation</option>
                            <option value="add">ADD</option>
                            <option value="subtract">SUBTRACT</option>
                            <option value="divide">DIVIDE</option>
                            <option value="multiply">MULTIPLY</option>
                        </select><br><br>
                        <input type="submit" name="submit" value="SUBMIT">
                    </form>
                </div>
            </div>
            <?php
                if(isset($_POST['submit'])){
                    $first_number = $_POST['first_number'];
                    $second_number = $_POST['second_number'];
                    $arithmetic_operation = $_POST['arithmetic_operation'];
                    $result = null;

                    switch($arithmetic_operation){
                        case "add":
                            $result = $first_number + $second_number;
                            break;
                        case "subtract":
                            $result = $first_number - $second_number;
                            break;
                        case "multiply":
                            $result = $first_number * $second_number;
                            break;
                        case "divide":
                            $result = $first_number / $second_number;
                            break;
                        // default:
                        //     echo "There was some error or mistake!";
                    }
                    if(is_int($result)){
                        echo "<h1 class='result_heading'>The {$arithmetic_operation} of {$first_number} and {$second_number} is {$result}</h1>";
                    }else{
                        echo "There was some error or mistake!";
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>