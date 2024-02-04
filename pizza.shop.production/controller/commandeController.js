import CommandeService from '../services/CommandeService.js';
const commandeService = new CommandeService();

class CommandeController {
    async listerCommandes(req, res) {
        try {
            const commandes = await commandeService.getCommandes();
            res.json(commandes);
        } catch (error) {
            console.error(error);
            res.status(500).json({ error: 'Internal Server Error' });
        }
    }

    async detailsCommande(req, res) {
        const commandeId = req.params.id;
        try {
            const commande = await commandeService.getCommandeById(commandeId);
            const items = await commandeService.getItemsByCommandeId(commandeId);
            res.json({ commande, items });
        } catch (error) {
            console.error(error);
            res.status(500).json({ error: 'Internal Server Error' });
        }
    }

    async changerEtatCommande(req, res) {
        const commandeId = req.params.id;
        const nouvelEtat = req.body.etat; // Assurez-vous que le client envoie le nouvel état dans le corps de la requête.

        try {
            await commandeService.changerEtatCommande(commandeId, nouvelEtat);
            res.json({ success: true, message: 'État de la commande mis à jour avec succès' });
        } catch (error) {
            console.error(error);
            res.status(500).json({ error: 'Internal Server Error' });
        }
    }
}

export default CommandeController;
