import express from 'express';
import routes from './routes/routes.js';
import MessageConsumerService from './services/MessageService.js';

const app = express();
const PORT = process.env.PORT || 3000;

const messageConsumerService = new MessageConsumerService();

messageConsumerService.consommerNouvellesCommandes();

app.use('/', routes);

app.use((req, res) => {
    res.status(404).json({ error: 'Not Found' });
});

app.use((err, req, res, next) => {
    console.error(err);
    res.status(500).json({ error: 'Internal Server Error' });
});

app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
