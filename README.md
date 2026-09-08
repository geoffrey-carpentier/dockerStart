# Docker Start

**Note** : Ce projet a été réalisé dans le cadre de ma formation de Développeur Web et Web Mobile (DWWM) au sein de La Plateforme.

Ce dépôt regroupe l'ensemble de mes travaux pratiques dédiés à l'apprentissage et à la maîtrise de **Docker** et **Docker Compose**. 

## Contenu du dépôt

Les exercices sont organisés sous forme de "jobs" progressifs :
- **Manipulation de base** : Gestion des images et conteneurs (`pull`, `run`, `stop`, `rm`, `ps`, etc.).
- **Création d'images (Dockerfile)** : Conteneurisation d'applications PHP/Apache et Node.js, incluant l'utilisation de **multistage builds** pour optimiser le poids des images.
- **Volumes** : Mise en place de la persistance des données.
- **Orchestration (Docker Compose)** : Déploiement d'une architecture multi-conteneurs complète (Front-end, API Back-end, BDD MySQL, et interface Adminer) au sein d'un réseau interne (`docker network`).
- **Preuves d'exécution** : Captures d'écran documentant la bonne exécution des commandes dans le terminal et le rendu navigateur.

## Installation et utilisation

1. Vous devez avoir [Docker Desktop](https://www.docker.com/products/docker-desktop/) (ou Docker Engine) installé sur votre système.
2. Clonez ce dépôt localement :
   ```bash
   git clone https://github.com/geoffrey-carpentier/dockerStart.git
   ```
3. Naviguez dans le dossier du job souhaité.
   - S'il contient un `Dockerfile`, construisez l'image :
     ```bash
     docker build -t nom_de_l_image .
     docker run -p 8080:80 nom_de_l_image
     ```
   - S'il contient un fichier `docker-compose.yml`, démarrez l'environnement complet :
     ```bash
     docker-compose up -d
     ```
4. Pour arrêter et nettoyer un environnement `docker-compose` :
   ```bash
   docker-compose down
   ```
