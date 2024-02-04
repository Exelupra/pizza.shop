import amqp from 'amqplib';

class MessagePublisherService {
    async publierChangementEtatCommande(commandeId, nouvelEtat) {
        const connection = await amqp.connect('amqp://rabbitmq');
        const channel = await connection.createChannel();

        await channel.assertQueue('suivi_commandes', { durable: true });

        const message = JSON.stringify({ commandeId, nouvelEtat });

        await channel.publish('pizzashop', 'suivi', Buffer.from(message));

        await channel.close();
        await connection.close();
    }
    async consommerNouvellesCommandes() {
        try {
            const connection = await amqp.connect('amqp://rabbitmq');
            const channel = await connection.createChannel();

            await channel.assertQueue('nouvelles_commandes', { durable: true });

            console.log("En attente de nouvelles commandes...");

            channel.consume('nouvelles_commandes', async (message) => {
                if (message !== null) {
                    try {
                        await this.commandeService.creerCommandeAPartirMessage(message);
                        channel.ack(message);
                    } catch (error) {
                        console.error(error);
                        channel.nack(message);
                    }
                }
            });
        } catch (error) {
            console.error(error);
        }
    }
}

export default MessagePublisherService;
