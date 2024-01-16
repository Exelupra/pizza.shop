<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Connexion à RabbitMQ
$connection = new AMQPStreamConnection('localhost', 5672, 'admin', '@dm1#!');
$channel = $connection->channel();

// Déclaration de la queue
$channel->queue_declare('nouvelles_commandes', false, true, false, false);

echo "En attente de messages. Pour arrêter le script, appuyez sur Ctrl+C.\n";

// Callback de traitement des messages
$callback = function (AMQPMessage $message) {
    // Décodage du contenu JSON
    $decodedMessage = json_decode($message->body, true);

    // Affichage du contenu du message
    echo "Message reçu:\n";
    print_r($decodedMessage);

    // Acquittement du message
    $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
};

// Consommation de messages en mode "consume"
$channel->basic_consume('nouvelles_commandes', '', false, false, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}

// Fermeture de la connexion
$channel->close();
$connection->close();
