<?php
    namespace Library;

    use Ratchet\MessageComponentInterface;
    use Ratchet\ConnectionInterface;

    class Notification implements MessageComponentInterface{
        protected $clients;
        protected $NotificationToken;

        public function __construct(){
            $this->clients = [];
        }

        public function onOpen(ConnectionInterface $wsconn){
            //EXTRACTED THE RECEIVER ID FROM URL
            // $query = $wsconn->httpRequest->getUri()->getQuery();
            // parse_str($query, $queryParams);
            // $sender_id = $queryParams['sender_id']??null;
            // $receiver_id = $queryParams['receiver_id']??null;

            //SET THE CONNECTION IN CLIENTS
            // if($sender_id && $receiver_id){
            //     $key = $sender_id.'_'.$receiver_id;
            //     $this->clients[$key] = []; 
            // }
            // $this->clients[$key][] = $wsconn;
            echo "Notification opened";
        }

        public function onMessage(ConnectionInterface $wsconn, $msg){
            $data = json_decode($msg, true);
            echo "Message data received! {$data['type']}";
            if($data['type'] === 'establish_notifications'){
                $sender_id = $data['sender_id'];
                // if(!isset($this->clients[$sender_id])){
                //     $this->clients[$sender_id] = null;
                // }
                $this->clients[$sender_id] = $wsconn;
                $wsconn->send(json_encode([
                    'type' => 'notification_established',
                    'message_text' => 'Notifications established for the sender'
                ]));
                echo "Sender notification ID created!";
            }
            // $receiver_id = $data['receiver_id'];
            // $sender_id = $data['sender_id'];
            // $key = $receiver_id.'_'.$sender_id;
            // $sender_receiver_key = $sender_id.'_'.$receiver_id;
            // if(isset($this->clients[$sender_receiver_key])){
            //     $this->clients[$sender_receiver_key] = [];
            // }
            // $this->clients[$sender_receiver_key][] = $wsconn;
            // $receiver_sender_key = $receiver_id.'_'.$sender_id;
            
            if($data['type'] === 'notification'){
                $receiver_id = $data['receiver_id'];
                $sender_id = $data['sender_id'];
                $message_text = $data['message_text'];
                // if(isset($this->clients[$key])){
                // if(isset($this->clients[$receiver_sender_key])){
                //     // foreach($this->clients[$key] as $client){
                //     foreach($this->clients[$receiver_sender_key] as $client){
                //         $client->send(json_encode([
                //             'type' => 'notification',
                //             'sender_id' => $sender_id,
                //             'receiver_id' => $receiver_id,
                //             'message_text' => $message_text
                //         ]));
                //         // echo "Notification: {$message_text}";
                //     }
                // }
                if(isset($this->clients[$receiver_id])){
                    // foreach($this->clients[$key] as $client){
                    // foreach($this->clients as $key => $client){
                    //     if($key === $receiver_id){
                    $client =$this->clients[$receiver_id];
                            $client->send(json_encode([
                                'type' => 'notification',
                                'sender_id' => $sender_id,
                                'receiver_id' => $receiver_id,
                                'message_text' => $message_text
                            ]));
                    //     }
                    //     // echo "Notification: {$message_text}";
                    // }
                }else{
                    echo "Receiver ID not found!";
                }
            }
        }

        public function onClose(ConnectionInterface $wsconn){
            foreach ($this->clients as $id => $client) {
                if ($client === $wsconn) {
                    // $this->clients[$id] = null;
                }
            }            
        }

        public function onError(ConnectionInterface $wsconn, \Exception $e){
            echo "onError: {$e->getMessage()}";
        }
    }
?>