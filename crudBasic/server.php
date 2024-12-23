<?php
require __DIR__ . '/vendor/autoload.php';
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\MainHandler;

include_once("database.php");
// Create WebSocket server
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new MainHandler($conn)
        )
    ),
    8080
);

echo "WebSocket server started on ws://localhost:8080\n";
$server->run();