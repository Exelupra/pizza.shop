<?php
require_once __DIR__ . '/../../vendor/autoload.php'; // Emplacement de l'autoloader généré par Composer

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'momo', 'momo');
$channel = $connection->channel();

$channel->queue_declare('nouvelles_commandes', false, true, false, false);

$message = $channel->basic_get('nouvelles_commandes');

if($message){
    $decodedMessage = json_decode($message->body, true);

    echo 'Message reçu : ' . print_r($decodedMessage, true) . PHP_EOL;

    $channel->basic_ack($message->delivery_info['delivery_tag']);
} else {
    echo 'Aucun message dans la file d\'attente' . PHP_EOL;
}

$channel->close();
$connection->close();
?>