# Pizza Shop
Pizza Shop est un projet de qu'on a fait en 3ème année de BUT informatique pour apprendre à construire des API ainsi que manier les redrections à d'autres API pour gérer des tâches externes tels que l'authentification JWT.

## ️👥 Auteurs
- Gallion Laura
- Demarque Amaury

## 💯Déploiement
Pour déployer l'application, il suffit de lancer les conteneurs de pizza.shop.components

```cd pizza.shop.components```

```docker compose create```

```docker compose start```

## 📃 Mise en place de la BDD
Pour mettre en place la base de donnée il va également nous falloir les mots de passes ainsi que les infos clés nécessaires écritent au prochain point.

### 🍔 BDD commande
Pour la BDD commande on va se rendre sur le lien adminer et entrer ces paramètres :

- System : MySQL
- Server : pizza-shop.commande.db
- Username : root
- Password : r00tpizz
- Database : pizza_shop

Ensuite cliquer sur l'onglet importer afin d'importer les 2 fichiers .sql (l'ordre est important) venant de pizza.shop/shop.pizza-shop/sql/

- pizza_shop.commande.schema.sql
- pizza_shop.commande.data.sql

### 📁 BDD catalogue
Pour la BDD catalogue on va se rendre sur le lien adminer et entrer ces paramètres :

- System : PostgreSQL
- Server : pizza-shop.catalogue.db
- Username : pizza_cat
- Password : pizza_cat
- Database : pizza_catalog

Ensuite cliquer sur l'onglet importer afin d'importer les 2 fichiers .sql (l'ordre est important) venant de pizza.shop/shop.pizza-shop/sql/

- pizza_shop.catalogue.schema.sql
- pizza_shop.catalogue.data.sql

### 🔑 BDD authentification
Pour la BDD catalogue on va se rendre sur le lien adminer et entrer ces paramètres :

- System : MySQL
- Server : pizza-shop.auth.db
- Username : root
- Password : r00tppipzz
- Database : pizza_shop

Ensuite cliquer sur l'onglet importer afin d'importer les 2 fichiers .sql (l'ordre est important) venant de pizza.shop/auth.pizza-shop/sql/

- pizza_shop.auth.schema.sql
- pizza_shop.auth.data.sql

### 🔑 BDD Production

Installer les dépendances nécessaires :

```npm install amqplib```
```npm install express knex mysql ```

Lancer le docker-compose :

```docker compose up```

Pour avoir accès à la base de donnée:
user:user
password:palia
db:pizza_shop
serveur:mysql

Pour avoir accès a RabbitMQ:
user:user
password:palia

Routes :
- 🟢 GET `/`
- 🟢 GET `/commandes`
- 🟢 GET `/commandes/:id`
- 🟢 PATCH `/commandes/:id/etat`
- 🟢 PATCH `/commandes/:id/changer-etat`


Ensuite cliquer sur l'onglet importer afin d'importer les 2 fichiers .sql (l'ordre est important) venant de pizza.shop/auth.pizza-shop/sql/

- pizza_shop.auth.schema.sql
- pizza_shop.auth.data.sql

Problème rencontré :
- Problème de connexion à la base de donnée avec Knex

## 🏹 Liens utiles, routes et compte

### ✨ Liens

- Gateway de pizza.shop : http://localhost:6980
- API Commande de pizza.shop : http://localhost:2080
- API Catalogue de pizza.shop : http://localhost:2081
- API Authentification de pizza.shop : http://localhost:2780
- Adminer : http://localhost:8080

### 🛣️ Routes du Gateway

- 🟢 GET `/produits`
- 🟢 GET `/produits/{id}`
- 🟢 GET `/categories/{id}/produits`
- 🟢 GET `/commandes/{id}`
- 🟠 POST `/signin`
  - Passer l'email et le mot de passe en Basic Auth
- 🟠 POST `/signup`
  - Passer en Body : {'email' : '[votre email]', 'password' : '[votre mot de passe]', 'username' : '[votre username]'}
- 🟠 POST `/refresh`
  - Passer le refresh token en Bearer
- 🟠 POST `/commandes`
  - Passer en Body : {"mail_client": "[mail du client]", "type_livraison": [type de livraison 1 ou 2], "items": [ { "numero": [numero d'item], "taille": [taille d'item 1 ou 2], "quantite": [quantite d'item] } ] }
- 🔵 PATCH `/commandes/{id}`
  - Passer en Body : { "etat" : "payee" }


### 👤 Compte

- nom d'utilisateur : AlixPerrot@free.fr
- mot de passe : AlixPerrot
