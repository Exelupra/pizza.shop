
import CommandeController from '../controller/commandeController.js';
import express from 'express';
import MessagePublisherService from '../services/MessageService.js';

const router = express.Router();
const commandeController = new CommandeController();
const messagePublisherService = new MessagePublisherService();

router.get('/' , (req, res) => {
    res.send('Pizza shop node server is running on port 3000');
});

router.get('/commandes', commandeController.listerCommandes);
router.get('/commandes/:id', commandeController.detailsCommande);
router.patch('/commandes/:id/etat', commandeController.changerEtatCommande);
router.patch('/commandes/:id/changer-etat', async (req, res) => {
    const commandeId = req.params.id;
    const nouvelEtat = req.body.nouvelEtat;

    try {
        await commandeController.changerEtatCommande(commandeId, nouvelEtat);
        await messagePublisherService.publierChangementEtatCommande(commandeId, nouvelEtat);
        res.json({ success: true });
    } catch (error) {
        console.error(error);
        res.status(500).json({ error: 'Internal Server Error' });
    }
});

export default router;
