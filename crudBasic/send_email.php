<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    // Include the Composer autoloader
    require 'vendor/autoload.php';
    function send_email($email, $full_name, $activation_url){
        //Email code again starts here
        try {
            //PHPMailer code starts here
            
            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);
            //PHPMailer code ends here
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
            $mail->Subject = "Registration Successful!";
            $mail->Body = "<h1>Hello, {$full_name}!</h1><p>Your account has been created on the website. Please activate your account by clicking on this link: <br> {$activation_url}</p>";

            // Send email
            $mail->send();
            echo "<p style='color: green; text-align: center'>Please check your inbox!</p><br>";

            //Email send code again ends here
            header("Location: login.php");
        } catch (Exception $e) {
            echo "Email could not be sent. Error: {$mail->ErrorInfo}";
        }
    }
?>