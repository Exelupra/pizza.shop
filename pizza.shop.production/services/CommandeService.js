import knex from 'knex';
const knexInstance = knex({
    client: 'mysql',
    connection: {
        host: '127.0.0.1',
        port: 3306,
        user: 'user',
        password:'palia' ,
        database: 'pizza_shop'
    }
});

class CommandeService {
    async getCommandes() {
        return await knexInstance('commande').select('*').orderBy('date_commande', 'desc');
    }

    async getCommandeById(id) {
        return await knexInstance('commande').where({ id: id }).first();
    }

    async getItemsByCommandeId(commandeId) {
        return await knexInstance('item').where({ commande_id: commandeId });
    }
    async changerEtatCommande(commandeId, nouvelEtat) {
        try {
            if (![1, 2, 3].includes(nouvelEtat)) {
                throw new Error('État invalide. Utilisez 1, 2 ou 3.');
            }
            await knexInstance('commande').where({ id: commandeId }).update({ etat: nouvelEtat });
            return true;
        } catch (error) {
            console.error(error);
            throw error;
        }
    }
    async creerCommandeAPartirMessage(message) {
        try {
            const { id, date_commande, type_livraison, montant_total, mail_client } = JSON.parse(message);

            const nouvelleCommande = {
                id,
                date_commande,
                type_livraison,
                etat: 1,
                montant_total,
                mail_client,
            };

            await knexInstance('commande').insert(nouvelleCommande);
            return true;
        } catch (error) {
            console.error(error);
            throw error;
        }
    }

}

export default CommandeService;
