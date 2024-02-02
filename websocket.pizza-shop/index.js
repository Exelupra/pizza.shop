// Import du package ws
const WebSocket = require('ws');

// Création du serveur websocket
const wss = new WebSocket.Server({ port: 8080 });

// Gestion des connexions des clients
wss.on('connection', function connection(ws) {
  ws.on('message', function incoming(message) {
    // Logique pour associer le client à l'identifiant de la commande
    console.log('Received message: %s', message);
  });
  // Logique pour mémoriser le client et envoyer une notification d'abonnement
  ws.send('Vous êtes abonné au suivi de cette commande.');
});

// Envoi de notifications d'état de commande
// Logique pour envoyer des notifications aux clients abonnés lors d'un changement d'état de commande