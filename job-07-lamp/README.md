# Job 07 — Stack LAMP avec Docker Compose

## Objectif

Créer une stack LAMP avec PHP 8.2, MySQL 8 et phpMyAdmin, en évitant le conflit de port avec Laragon en **ne publiant pas MySQL sur le port hôte 3306**.

## Ce qu’il faut obtenir

- une page PHP avec test de connexion MySQL,
- une page `phpinfo()` accessible à la demande,
- phpMyAdmin accessible sur `http://localhost:8081`,
- une base MySQL persistée dans un volume nommé,
- un `README.md` clair et rejouable par quelqu’un d’autre.

## Prérequis

- Docker Desktop démarré
- Docker Compose disponible
- Laragon pouvant rester actif sans conflit sur le port 3306 hôte

## Architecture

| Service      | Image                             | Port hôte       | Rôle                                       |
| ------------ | --------------------------------- | --------------- | ------------------------------------------ |
| `php`        | `php:8.2-apache` via `Dockerfile` | `8080`          | Application PHP + test MySQL               |
| `db`         | `mysql:8`                         | aucun port hôte | Base MySQL interne, persistance via volume |
| `phpmyadmin` | `phpmyadmin/phpmyadmin`           | `8081`          | Administration de la base                  |

> MySQL n’est pas exposé sur le port hôte pour éviter le conflit avec Laragon. Les conteneurs communiquent entre eux via le réseau Docker et le nom de service `db`.

## Structure du projet

```text
job-07-lamp/
├── Dockerfile
├── docker-compose.yml
├── .env
├── .env.example
├── .gitignore
├── README.md
├── capture.js
├── images/
└── src/
    └── index.php
```

## Fichiers de configuration

### `.env`

Contient les valeurs locales utilisées par MySQL et par l’application PHP.

### `.env.example`

Contient le même jeu de clés, sans secret sensible, pour servir de modèle.

### `.gitignore`

Au minimum, `.env` y figure.

## Déroulé d’exécution

### 1. Démarrer la base seule

```bash
docker compose up -d db
```

Prendre la capture du démarrage du service MySQL.

- **Fichier image :** `01-job07-compose-up-db-only.png`

Puis vérifier l’état des conteneurs.

```bash
docker compose ps
```

- **Fichier image :** `02-job07-compose-ps-db-only.png`

### 2. Vérifier la base de données

Se connecter au conteneur MySQL :

```bash
docker compose exec db mysql -u root -p
```

Puis dans MySQL :

```sql
SHOW DATABASES;
```

Attendre de voir `lamp_demo` dans la liste.

- **Fichier image :** `03-job07-mysql-show-databases.png`

### 3. Démarrer la pile complète

```bash
docker compose up -d --build
```

### 4. Captures navigateur automatisables

Quand les services répondent, lancer :

```bash
node capture.js
```

Ce script crée automatiquement :

- `04-job07-phpinfo-browser.png`
- `05-job07-php-connection-ok.png`
- `06-job07-phpmyadmin-login.png`

### 5. Compléter manuellement la partie phpMyAdmin

Ouvrir :

```text
http://localhost:8081
```

Se connecter avec les identifiants de `.env`, puis prendre la capture de la base ouverte.

- **Fichier image :** `07-job07-phpmyadmin-lamp-demo.png`

Créer ensuite une table de test dans `lamp_demo`.

- **Fichier image :** `08-job07-phpmyadmin-table-created.png`

### 6. Tester la persistance

Arrêter puis relancer la stack :

```bash
docker compose down
docker compose up -d
```

Revenir dans phpMyAdmin et vérifier que la table est toujours présente.

- **Fichier image :** `09-job07-persistence-after-restart.png`

### 7. Arrêter proprement

```bash
docker compose down
```

- **Fichier image :** `10-job07-compose-down.png`

## Captures à prendre dans l’ordre

1. `01-job07-compose-up-db-only.png` — démarrage du service `db` seul.
2. `02-job07-compose-ps-db-only.png` — `docker compose ps`.
3. `03-job07-mysql-show-databases.png` — `SHOW DATABASES;` avec `lamp_demo`.
4. `04-job07-phpinfo-browser.png` — `http://localhost:8080/?phpinfo=1`.
5. `05-job07-php-connection-ok.png` — page d’accueil PHP avec test de connexion.
6. `06-job07-phpmyadmin-login.png` — écran de connexion phpMyAdmin.
7. `07-job07-phpmyadmin-lamp-demo.png` — phpMyAdmin connecté à `lamp_demo`.
8. `08-job07-phpmyadmin-table-created.png` — table créée dans phpMyAdmin.
9. `09-job07-persistence-after-restart.png` — table toujours visible après `down` puis `up -d`.
10. `10-job07-compose-down.png` — arrêt propre de la stack.

## Guide rapide pour les screenshots

- Les captures terminal restent manuelles.
- Les vues navigateur 04 à 06 peuvent être automatisées avec `capture.js`.
- La capture 07 doit être faite après authentification dans phpMyAdmin.
- Les captures 08 et 09 se font après création d’une table de test.

## Commandes utiles

```bash
docker compose up -d db
docker compose ps
docker compose exec db mysql -u root -p
docker compose up -d --build
docker compose down
docker compose down -v
```

## Bilan attendu

- MySQL démarre sans conflit avec Laragon,
- PHP affiche la page d’accueil et le test de connexion,
- phpMyAdmin s’ouvre sur `localhost:8081`,
- la base `lamp_demo` est persistée,
- le README permet de refaire l’exercice sans ambiguïté.
