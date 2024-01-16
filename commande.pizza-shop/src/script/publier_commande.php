<?php

namespace pizzashop\commande\script;


require_once __DIR__ . '/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Connexion à RabbitMQ
$connection = new AMQPStreamConnection('localhost', 5672, 'admin', '@dm1#!');
$channel = $connection->channel();

// Déclaration de la queue
$channel->queue_declare('nouvelles_commandes', false, true, false, false);

// Création d'une commande aléatoire (exemple)
$command = [
    'id' => uniqid(),
    'product' => 'Example deux fromages',
    'quantity' => rand(1, 10),
    // ... autres champs de la commande
];

// Sérialisation de la commande en JSON
$jsonCommand = json_encode($command);

// Création d'un message
$message = new AMQPMessage($jsonCommand);

// Publication du message dans la queue
$channel->basic_publish($message, '', 'nouvelles_commandes');

// Affichage de la commande publiée
echo "Commande publiée:\n";
print_r($command);

// Fermeture de la connexion
$channel->close();
$connection->close();
