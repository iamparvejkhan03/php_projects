<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    session_start();
    // Include the Composer autoloader
    require 'vendor/autoload.php';
    function send_email($email, $full_name, $subject, $body, $success_message, $header){
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
            $mail->Subject = "{$subject}";
            $mail->Body = "{$body}";

            // Send email
            $mail->send();
            //Email send code again ends here
            $_SESSION['login_notice'] = $success_message;
            header($header);
            // echo "{$success_message}<br>";
        } catch (Exception $e) {
            echo "Email could not be sent. Error: {$mail->ErrorInfo}";
        }
    }
?>