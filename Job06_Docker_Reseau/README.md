# Job 06 - Docker Réseau : application multi-conteneurs

Formation Docker - La Plateforme DWWM

## Objectif

Créer et documenter une application multi-conteneurs avec Docker Compose comprenant :

- une base de données MySQL,
- un backend Node.js,
- un frontend Nginx,
- une interface d'administration Adminer.

## Architecture

| Service  | Image                         | Port   | Rôle                 |
| -------- | ----------------------------- | ------ | -------------------- |
| database | `mysql:8.0`                   | `3306` | Base de données      |
| backend  | build local Node.js 16-alpine | `3000` | API Node.js          |
| nginx    | `nginx:alpine`                | `8080` | Frontend et proxy    |
| adminer  | `adminer:latest`              | `8081` | Administration MySQL |

## Structure du projet

```text
Job06_Docker_Reseau/
├── docker-compose.yml
├── backend/
│   ├── Dockerfile
│   ├── package.json
│   └── server.js
├── frontend/
│   └── index.html
├── nginx/
│   └── nginx.conf
└── images/
```

## Utilisation du starter-kit

Le dossier `starter-docker-Jour-4_Job-06-main` sert de base de départ pour les fichiers applicatifs :

- `backend/`
- `frontend/`
- `nginx/`
- `README.md`

Le projet final ajoute `docker-compose.yml` et le dossier `images/` pour centraliser les captures d'écran.

## Déroulé attendu

1. Lancer le projet avec Docker Compose.
2. Vérifier l’accès au backend sur `http://localhost:3000`.
3. Vérifier l’accès au frontend sur `http://localhost:8080`.
4. Vérifier Adminer sur `http://localhost:8081`.
5. Tester la connexion backend ↔ base de données.
6. Ajouter les captures d’écran dans `images/`.
7. Compléter ce README avec les captures et les explications étape par étape.

## Consignes de rendu

- Faire des captures d’écran à chaque étape importante.
- Intégrer les images dans ce `README.md`.
- Stocker les captures dans le dossier `images/` du projet.
- Faire des commits réguliers, avec un nom et une description explicites.
- Partager le projet complet sur GitHub.

## Illustrations / captures d'écran

Pour garder un README lisible et homogène, les captures ci-dessous sont organisées par étape et numérotées par ordre de réalisation.
Pour chaque point on peut retrouver une capture du terminal quand elle apporte une vraie information et/ou une capture du navigateur ou de Docker Desktop quand elle rend la démonstration plus lisible et compréhensible.

- `01-...` : lancement du projet
- `02-...` : vérification des conteneurs
- `03-...` à `06-...` : accès aux services web
- `07-...` à `09-...` : vérifications MySQL / Adminer / terminal
- `10-...` : arrêt et nettoyage

Ces fichiers sont placés dans le dossier `images/`.


### 1. Démarrage complet de la stack

Pour lancer le projet avec Docker Compose, on entre la commande suivante dans le terminal:

```bash
docker compose up -d --build
```

![Lancement complet du projet](./images/01-job06-compose-up-cmd.png)

Après le lancement, on vérifie l’état des services avec :

```bash
docker compose ps
```

![Etat des services dans le terminal](./images/02-job06-compose-ps-cmd.png)

On peut aussi consulter Docker Desktop pour une vue plus graphique de l’état des conteneurs, des réseaux et des volumes :

![Vue d'ensemble dans Docker Desktop](./images/02-job06-compose-ps-desktop.png)

Cette première étape confirme que l’image backend est bien construite, que les réseaux sont créés et que les quatre services démarrent sans erreur bloquante.

### 2. Vérification du backend

Afin de vérifier que le backend Node.js répond correctement, on ouvre le navigateur et on accède à l’adresse suivante : `http://localhost:3000/`

![Rendu du message dans le navigateur](./images/03-job06-backend-root-browser.png)

Ou on peut alternativement utiliser `curl` pour interroger les routes définies dans `server.js` (terminal).

```bash
curl http://localhost:3000/
```

![Réponse du backend sur la route /](./images/03-job06-backend-root-cmd.png)

Pour consulter le statut de l’API et vérifier la connexion à MySQL, on peut interroger la route `/api/status` :
```bash
curl http://localhost:3000/api/status
```
![Réponse JSON de la route /api/status](./images/04-job06-backend-status-cmd.png)

ou visualiser la réponse directement dans le navigateur à l’adresse `http://localhost:3000/api/status`.

![Vue complémentaire de la réponse API](./images/04-job06-backend-status-desktop.png)

L’objectif ici est de prouver que le backend Node.js répond correctement et qu’il sait interroger MySQL pour renvoyer l’heure actuelle, ce qui est le cas ici.

### 3. Vérification du frontend Nginx

Commande / action :

On vérifie l’accès au frontend en accédant à l’adresse suivante dans le navigateur :

```bash
http://localhost:8080
```

![Page frontend avec le statut de l'API](./images/05-job06-frontend-browser.png)

La page affiche le message de bienvenue et le statut de l’API.
Cela confirme que Nginx sert bien la page statique et relaie la requête `/api/status` vers le backend.

On peut faire cette vérification en entrant la commande suivante dans le terminal pour interroger directement le frontend :

```bash
curl http://localhost:8080
```

On obtient une réponse HTML qui affiche le contenu de `index.html` et le statut de l’API, ce qui confirme que le frontend est opérationnel et communique correctement avec le backend.
![Accès ou vérification côté terminal](./images/05-job06-frontend-cmd.png)

### 4. Vérification d’Adminer

Commande / action :

On accède à Adminer en ouvrant l’adresse suivante dans le navigateur :
```text
http://localhost:8081
```
![Ecran Adminer avant authentification](./images/06-job06-adminer-browser.png)

Les paramètres utilisés pour la connexion :

![Ecran Adminer champs remplis](./images/06-job06-adminer-browser-filled.png)

- Serveur : `database`
- Utilisateur : `root`
- Mot de passe : `root`
- Base de données : `projetdb`
  
Après validation, on accède à l’interface d’administration de la base de données MySQL, ce qui confirme que Adminer se connecte correctement au service `database` et que les identifiants sont fonctionnels.

![Session Adminer ouverte sur la base](./images/06-job06-adminer-logged-in.png)

Depuis l'interface d'Adminer, on peut consulter les données existantes ou manipuler la base de données.
Il est possible par exemple de créer une table de test pour vérifier que les opérations de base fonctionnent correctement, (communication réseau entre Adminer et MySQL opérationnelle):

![Formulaire de création d'une table](./images/06-job06-adminer-table-creation.png)

![Confirmation après création](./images/06-job06-adminer-table-created.png)

L’administration graphique de la base est bien opérationnelle et qu’Adminer se connecte au service `database`.

### 5. Exploration MySQL dans le terminal

Pour accéder au container via le terminal et se connecter au shell MySQL, on utilise la commande suivante :

```bash
docker exec -it database mysql -u root -p
```

Puis dans MySQL :

```sql
SHOW DATABASES;
```
permet d'afficher la liste des bases de données, dont `projetdb` qui est bien visible.

![Connexion réussie au shell MySQL](./images/07-job06-mysql-shell.png)

Cela permet de vérifier que la base `projetdb` est bien créée et accessible depuis le terminal, ce qui confirme la communication réseau entre les conteneurs et la bonne configuration de MySQL.

Ensuite, on peut sortir proprement du shell MySQL avec la simple commande:

```sql
exit
```

![Liste des bases et sortie du shell](./images/08-job06-mysql-databases-exit.png)

### 6. Vérification de la communication réseau et de l’environnement Docker

Captures complémentaires pertinentes :

![Vue d'ensemble de l'environnement Docker](./images/09-job06-docker.png)

![Etat de la page d'accueil ou premier affichage utile](./images/09-job06-front-root.png)

![Consultation de la base depuis l'interface graphique](./images/09-job06-front-BDD-mysql.png)

![Liste des bases visibles dans l'interface](./images/09-job06-front-liste-bdd.png)

![Schéma système ou vue technique de la base](./images/09-job06-front-performance-schema.png)

![Vue des processus ou état associé](./images/09-job06-front-processus.png)

![Requête SQL exécutée dans l'interface](./images/09-job06-front-sql-requete.png)

![Table système ou configuration consultée](./images/09-job06-front-table-sys-config.png)

Ces captures sont utiles pour enrichir le rendu en montrant des étapes de manipulation de la base et de l’interface d’administration, ainsi que pour illustrer la communication entre les services et la configuration de l’environnement Docker.

### 7. Arrêt et nettoyage

Commande :

```bash
docker compose down
```

Capture intégrée :

![Arret de la stack](./images/10-job06-compose-down.png)

Cette dernière étape clôture proprement le projet et montre que les conteneurs peuvent être arrêtés sans erreur.

## Bilan de validation des étapes de l'énoncé

- Le fichier `docker-compose.yml` définit bien les quatre services demandés : `database`, `backend`, `nginx` et `adminer`.
- Le backend répond correctement sur `http://localhost:3000/` et `http://localhost:3000/api/status`.
- Le frontend est accessible sur `http://localhost:8080` et affiche l’état de l’API.
- Adminer est accessible sur `http://localhost:8081` avec les identifiants demandés.
- La connexion au shell MySQL a été réalisée depuis le terminal et la liste des bases a été affichée.
- Les réseaux, ports et volumes nécessaires ont été validés au démarrage du stack.
- L’arrêt propre du projet avec `docker compose down` a été vérifié.

## Connexions attendues

### Backend

- `GET /` : message de bienvenue.
- `GET /api/status` : retourne l’heure actuelle si la base est joignable.

### Adminer

- Serveur : `database`
- Utilisateur : `root`
- Mot de passe : `root`
- Base de données : `projetdb`

## Commandes de démarrage

```bash
docker compose up -d --build
```

## Commandes de contrôle

```bash
docker compose ps
docker compose logs -f backend
```

## Checklist détaillée à suivre

### 1. Démarrer le projet

```bash
docker compose up -d --build
```

À vérifier :

- les 4 services démarrent,
- aucun service ne redémarre en boucle,
- le backend n’affiche pas d’erreur de connexion prolongée.

### 2. Vérifier l’état des services

```bash
docker compose ps
```

À vérifier :

- `database` est `Up`,
- `backend` est `Up`,
- `nginx` est `Up`,
- `adminer` est `Up`.

### 3. Tester le backend

```bash
curl http://localhost:3000/
curl http://localhost:3000/api/status
```

À vérifier :

- la route `/` renvoie un message de bienvenue,
- la route `/api/status` renvoie un JSON avec `status` et `currentTime`.

### 4. Tester le frontend

Ouvrir :

```text
http://localhost:8080
```

À vérifier :

- la page frontend s’affiche,
- le statut de l’API est visible dans la page.

### 5. Tester Adminer

Ouvrir :

```text
http://localhost:8081
```

Paramètres de connexion :

- Serveur : `database`
- Utilisateur : `root`
- Mot de passe : `root`
- Base de données : `projetdb`

### 6. Tester MySQL depuis le terminal

```bash
docker exec -it database mysql -u root -p
```

Puis dans MySQL :

```sql
SHOW DATABASES;
exit
```

### 7. Nettoyer à la fin

```bash
docker compose down
```

Si nécessaire, supprimer aussi les volumes avec prudence :

```bash
docker compose down -v
```

## Notes

- Les captures d’écran doivent rester cohérentes avec l’ordre des étapes.
- Les captures complémentaires ne doivent être conservées que si elles apportent une information utile.
- Le projet est volontairement structuré pour respecter l’énoncé du Job06 et s’appuie sur le starter-kit fourni.
