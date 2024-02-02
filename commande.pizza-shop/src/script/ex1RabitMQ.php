<?php

namespace pizzashop\commande\script;

require_once __DIR__ . '/../../vendor/autoload.php'; // Emplacement de l'autoloader généré par Composer

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'momo', 'momo');
$channel = $connection->channel();

$channel->queue_declare('nouvelles_commandes', false, true, false, false);

$commande = array(
    'id' => uniqid(),
    'produit' => 'Pizza',
    'quantite' => rand(1, 10)
);
$messageBody = json_encode($commande);

$msg = new AMQPMessage($messageBody); // Message persistant

$channel->basic_publish($msg, '', 'nouvelles_commandes');

echo 'Message publié : ' . $messageBody . PHP_EOL;

// Vérification de la transmission des messages dans l'interface de gestion

// Lecture d'un message avec différents modes d'acquittement
// ...

$channel->close();
$connection->close();
?>