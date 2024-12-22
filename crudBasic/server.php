<?php
require __DIR__ . '/vendor/autoload.php';
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $token;
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
            $this->token = $row['token'];
        } else {
            $this->token = $this->createChatToken();
        }
        // $this->joinChat($wsconn, $this->token);
        // Ensure the connection is not duplicated in the chat token list
        if (!isset($this->chatTokens[$this->token])) {
            $this->chatTokens[$this->token] = [];
        }

        if (!in_array($wsconn, $this->chatTokens[$this->token], true)) {
            $this->chatTokens[$this->token][] = $wsconn;
            echo "Connection {$wsconn->resourceId} associated with token: {$this->token}\n";
        }

        $message_text = $data['message_text'];
        $insert = "INSERT INTO messages (sender_id, receiver_id, message_text, token) VALUES ('$sender_id', '$receiver_id', '$message_text', '$this->token')";
        $mysqli_insert_query = mysqli_query($this->dbconn, $insert);
        if($mysqli_insert_query){
            echo "Inserted data into database";
        }else{
            echo "Could not insert into database";
        }
        // Route the message only to connections associated with the token
        foreach ($this->chatTokens[$this->token] as $client) {
                $client->send(json_encode([
                        'token' => $this->token,
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
        foreach($this->chatTokens as $token => &$connections){
            foreach($connections as $index => $connection){
                if($connection === $wsconn){
                    unset($connections[$index]);
                }
            }
        }
        echo "Connection {$wsconn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $wsconn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $wsconn->close();
    }

    // Generate a unique token for a new chat session
    public function createChatToken() {
        $tok = bin2hex(random_bytes(16)); // Generate a secure random token
        return $tok;
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