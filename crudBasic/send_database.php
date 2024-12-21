<?php
include_once("database.php");
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(!isset($_POST['message'])){
            echo "NO data fetched through fetch request";
        }else{
            $message_text = $_POST['message'];
            $receiver_id = $_POST['receiver_id'];
            $sender_id = $_POST['sender_id'];
        }
    }
    
        $insert = "INSERT INTO messages (sender_id, receiver_id, message_text) VALUES ('$sender_id', '$receiver_id', '$message_text')";
        $mysqli_insert_query = mysqli_query($conn, $insert);
        if($mysqli_insert_query){
            echo "Message inserted into database.";
        }else{
            echo "Could not insert the message into database.";
        }






// Include database connection
// include_once('database.php'); // Update with the correct path

// Validate and sanitize POST data
// $sender_id = isset($_POST['sender_id']) ? intval($_POST['sender_id']) : null;
// $receiver_id = isset($_POST['receiver_id']) ? intval($_POST['receiver_id']) : null;
// $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message']), ENT_QUOTES, 'UTF-8') : null;

// if ($sender_id && $receiver_id && $message) {
//     // Insert message into database
//     $query = "INSERT INTO messages (sender_id, receiver_id, message_text) VALUES (?, ?, ?)";
//     $stmt = $conn->prepare($query);
//     $stmt->bind_param("iis", $sender_id, $receiver_id, $message);

//     if ($stmt->execute()) {
//         echo "Message saved successfully!";
//     } else {
//         echo "Failed to save message: " . $stmt->error;
//     }
//     $stmt->close();
// } else {
//     echo "Error: Missing required data.";
// }
?>
