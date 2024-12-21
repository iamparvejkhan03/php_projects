<?php
require __DIR__ . '/vendor/autoload.php';
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $dbconn;
    protected $chatTokens; // Store tokens and associated connections

    public function __construct($dbconnection) {
        $this->clients = new \SplObjectStorage;
        $this->dbconn = $dbconnection;
        $this->chatTokens = []; // Format: ['token' => [ConnectionInterface]]
    }

    public function onOpen(ConnectionInterface $wsconn) {
        $this->clients->attach($wsconn);
        echo "New connection! ({$wsconn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $wsconn, $msg) {
        $data = json_decode($msg, true);
        $sender_id = $data['sender_id'];
        $receiver_id = $data['receiver_id'];

        $select = "SELECT token FROM messages 
               WHERE (sender_id = '$sender_id' AND receiver_id = '$receiver_id') 
                  OR (receiver_id = '$sender_id' AND sender_id = '$receiver_id') 
               LIMIT 1";
        $result = mysqli_query($this->dbconn, $select);

        if ($row = mysqli_fetch_assoc($result)) {
            $token = $row['token'];
        } else {
            $token = $this->createChatToken();
            // $insert = "INSERT INTO messages (sender_id, receiver_id, token) VALUES ('$sender_id', '$receiver_id', '$token')";
            // mysqli_query($this->dbconn, $insert);
        }
        $this->joinChat($wsconn, $token);

        $message_text = $data['message_text'];
        $insert = "INSERT INTO messages (sender_id, receiver_id, message_text, token) VALUES ('$sender_id', '$receiver_id', '$message_text', '$token')";
        $mysqli_insert_query = mysqli_query($this->dbconn, $insert);
        if($mysqli_insert_query){
            echo "Inserted data into database";
        }else{
            echo "Could not insert into database";
        }
        // Route the message only to connections associated with the token
        foreach ($this->clients as $client) {
            // if ($client !== $from) { // Do not echo message back to the sender
                $client->send(json_encode([
                        'token' => $token,
                        'sender_id' => $sender_id,
                        'receiver_id' => $receiver_id,
                        'message_text' => $message_text
                        ]));
                echo "Data sent!";
            // }
        }
    }

    public function onClose(ConnectionInterface $wsconn) {
        // Detach connection
        $this->clients->detach($wsconn);
        
        

        echo "Connection {$wsconn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $wsconn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $wsconn->close();
    }

    // Generate a unique token for a new chat session
    public function createChatToken() {
        $tok = bin2hex(random_bytes(16)); // Generate a secure random token
        // $this->chatTokens[$tok] = [];    // Initialize empty connections array
        return $tok;
    }

    // Assign a connection to a specific token
    public function joinChat(ConnectionInterface $wsconn, $token) {
        if (isset($this->chatTokens[$token])) {
            $this->chatTokens[$token] = $wsconn;
            echo "Connection {$wsconn->resourceId} joined chat with token: $token\n";
        } else {
            // echo "Invalid token: $token\n";
            // $wsconn->send(json_encode(['error' => 'Invalid chat token']));
            // $wsconn->close();
            $this->chatTokens[$token] = $wsconn;
        }
    }
}
include_once("database.php");
// Create WebSocket server
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat($conn)
        )
    ),
    8080
);

echo "WebSocket server started on ws://localhost:8080\n";
$server->run();