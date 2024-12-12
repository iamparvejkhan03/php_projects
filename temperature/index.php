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
        <div id="temperature_converter">
            <div class="heading_container">
                <h1>TEMPERATURE CONVERTER</h1>
            </div><br><br>
            <form action="index.php" method="post">
                <label for="temperature">TEMPERATURE:</label><br>
                <input type="number" step="0.5" name="temperature" id="temperature"><br><br>
                <label for="unit">UNIT:</label><br><br>
                <select name="unit" id="unit">
                    <option value="unit">CONVERT TO</option>
                    <option value="celcius">CELCIUS</option>
                    <option value="fehrenheit">FEHRENHEIT</option>
                </select><br><br>
                <input type="submit" name="convert" value="CONVERT">
            </form>
            <?php
            if(isset($_POST['convert'])){
                $temperature = $_POST['temperature'];
                $unit = $_POST['unit'];
                $result = null;

                if($unit == "fehrenheit"){
                    $result = ($temperature * 9/5) + 32;
                }elseif($unit == "celcius"){
                    $result = ($temperature - 32) * 5/9;
                }
                echo "<h1 class='result_heading'>RESULT: {$result}° " . strtoupper($unit) . "</h1>";
            }
        ?>
        </div>
    </div>
</body>
</html>