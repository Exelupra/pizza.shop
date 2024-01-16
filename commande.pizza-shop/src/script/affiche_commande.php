<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Connexion à RabbitMQ
$connection = new AMQPStreamConnection('localhost', 5672, 'admin', '@dm1#!');
$channel = $connection->channel();

// Déclaration de la queue
$channel->queue_declare('nouvelles_commandes', false, true, false, false);

// Récupération d'un message en mode GET
$message = $channel->basic_get('nouvelles_commandes');

if ($message) {
    // Décodage du contenu JSON
    $decodedMessage = json_decode($message->body, true);

    // Affichage du contenu du message
    echo "Message reçu:\n";
    print_r($decodedMessage);

    // Acquittement du message
    $channel->basic_ack($message->delivery_info['delivery_tag']);
} else {
    echo "Aucun message dans la file d'attente.\n";
}

// Fermeture de la connexion
$channel->close();
$connection->close();
