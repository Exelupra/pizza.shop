<?php

require_once __DIR__ . '/../../vendor/autoload.php'; // Inclure l'autoloader de Composer

// Connexion au serveur <link>RabbitMQ</link>
$connection = new PhpAmqpLib\Connection\AMQPStreamConnection('localhost', 5672, 'momo', 'momo');
$channel = $connection->channel();

// Déclarer une file de message
$channel->queue_declare('nouvelles_commandes', false, true, false, false);

// Callback de traitement des messages
$callback = function ($msg) {
    echo "Message reçu : " . $msg->body . "\n";
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']); // Acquitter le message
};

// Souscrire à la queue et consommer les messages
$channel->basic_consume('nouvelles_commandes', '', false, false, false, false, $callback);

// Attendre les messages
while (count($channel->callbacks)) {
    $channel->wait();
}

// Fermer la connexion
$channel->close();
$connection->close();