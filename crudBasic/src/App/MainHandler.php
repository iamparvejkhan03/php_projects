<?php
    namespace App;
    use Ratchet\MessageComponentInterface;
    use Ratchet\ConnectionInterface;
    use Library\Chat;
    use Library\Notification;

    class MainHandler implements MessageComponentInterface{
        protected $chatHandler;
        protected $notificationHandler;

        public function __construct($dbconn){
            $this->chatHandler = new Chat($dbconn);
            $this->notificationHandler = new Notification();
        }

        public function onOpen(ConnectionInterface $wsconn){
            $this->chatHandler->onOpen($wsconn);
            $this->notificationHandler->onOpen($wsconn);
        }

        public function onMessage(ConnectionInterface $wsconn, $msg){
            $data = json_decode($msg, true);
            file_put_contents('mainhandler_log.txt', print_r($data, true));

            if($data['type'] === 'message' || $data['type'] === 'token'){
                $msg = json_encode($data);
                $this->chatHandler->onMessage($wsconn, $msg);
            }
            if($data['type'] === 'establish_notifications' || $data['type'] === 'notification'){
                $msg = json_encode($data);
                $this->notificationHandler->onMessage($wsconn, $msg);
            }
        }

        public function onClose(ConnectionInterface $wsconn){
            $this->chatHandler->onClose($wsconn);
            $this->notificationHandler->onClose($wsconn);
        }

        public function onError(ConnectionInterface $wsconn, \Exception $e){
            $this->chatHandler->onError($wsconn, $e);
            $this->notificationHandler->onError($wsconn, $e);
        }
    }
?>