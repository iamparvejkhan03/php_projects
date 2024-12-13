<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Happy+Monkey&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Email Send</title>
</head>
<body>
    <div id="main">
    <?php
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        // Include the Composer autoloader
        require 'vendor/autoload.php';

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        //PK form code

        if(isset($_POST['send'])){
            $full_name = $_POST['full_name'];
            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            try {
                // SMTP configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Set the SMTP server
                $mail->SMTPAuth = true; // Enable SMTP authentication
                $mail->Username = 'parvejsahid2@gmail.com'; // Your Gmail address
                $mail->Password = 'hknc psif ovgy lkjy'; // Your Gmail password or app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable encryption
                $mail->Port = 587; // TCP port to connect to
    
                // Email settings
                $mail->setFrom('parvejsahid2@gmail.com', 'Parvej Khan'); // Sender's email and name
                $mail->addAddress("$email", "$full_name"); // Add recipient
    
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = "$subject";
                $mail->Body = "<h1>Hello, {$full_name}!</h1><p>{$message}</p>";
    
                // Send email
                $mail->send();
                echo "<p style='color: green; text-align: center'>Email has been sent successfully!</p><br>";
            } catch (Exception $e) {
                echo "Email could not be sent. Error: {$mail->ErrorInfo}";
            }
        }
        ?>
        <form action="index.php" method="post">
            <input type="text" placeholder="FULL NAME" name="full_name"><br><br>
            <input type="email" placeholder="E-MAIL ID" name="email"><br><br>
            <input type="text" placeholder="SUBJECT" name="subject"><br><br>
            <textarea name="message" placeholder="YOUR MESSAGE"></textarea><br><br>
            <input type="submit" name="send" value="SEND">
        </form>
    </div>
</body>
</html>