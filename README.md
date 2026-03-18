# Docker - Plateforme DWWM

## Job 01 : Welcome to Docker & Commandes de base

**Objectif :** Préparer l'environnement et manipuler les commandes fondamentales.
**Prérequis :** Avoir Docker installé et en cours d'exécution.

¤ [Lien du fichier d'installation](https://docs.docker.com/desktop/install/windows-install/)
¤ [Lien de la documentation](https://docs.docker.com/reference/)

Puis dans Visual-studio ou dans terminal (cmd, powershell...) on va taper les commandes de base pour vérifier que Docker est bien installé et opérationnel.

### 1. Vérification de l'installation

_Pour s'assurer que Docker est bien installé et opérationnel, on vérifie la version :_

```bash
docker --version
# ou docker -v
```

![docker version](./screenshots/1-Docker-v.png)

> version **29.2.1** => **docker** est bien installé

### 2. Informations système

```bash
docker info
```

![docker info](./screenshots/2-Docker-info.png)

> **info** permet d'afficher toutes les infos du système Docker (Conteneurs, Images, etc.)

---

## Test des commandes de base

### 3. Vérifier les conteneurs en cours d'exécution

```bash
docker ps
```

![docker ps](./screenshots/3-Docker-ps.png)

> Affiche les conteneurs actuellement actifs. Aucun au départ.

### 4. Lister les images disponibles localement

```bash
docker images
```

![docker images](./screenshots/4-docker-images.png)

> Montre les images Docker présentes sur la machine.

### 5. Lancer le conteneur "Welcome to Docker"

```bash
docker run -it --rm -p 8088:80 docker/welcome-to-docker
```

![docker run welcome](./screenshots/9-docker_run_-it_--rm_-p_xxxx80_.welcome.png)

> Lance un conteneur en mode interactif (-it), expose le port 8088 de la machine vers le port 80 du conteneur, et supprime le conteneur automatiquement à l'arrêt (--rm).
>
> **Résultat :** Accès à http://localhost:8088 dans un navigateur
> ***Notes :***
>- Le conteneur doit être arrêté manuellement (CTRL+C) pour revenir au terminal.
>-  Pour faire tourner le conteneur en arrière-plan, utiliser `-d` (détaché) et entrer `docker stop <id>` pour l'arrêter ensuite:
> `docker run -d -p 8088:80 docker/welcome-to-docker`
> puis
>  `docker stop <id>` pour arrêter.
>- Les options `-it` et `-d` peuvent être combinées pour lancer en mode interactif et détaché (mais il faut alors gérer les logs pour voir la sortie du conteneur).

### 6. Arrêter le conteneur

```bash
docker stop <container_id|container_name>
```

![docker stop](./screenshots/docker-stop.jpg)

> Arrête "gracieusement" le conteneur (sans le supprimer).

### 7. Télécharger l'image hello-world

```bash
docker pull hello-world
```

![docker pull hello-world](./screenshots/7-Docker-pull.png)

> Télécharge l'image "hello-world" depuis Docker Hub vers la machine locale.

### 8. Vérifier que l'image est bien présente

```bash
docker images
```

![docker images after pull](./screenshots/8-Docker-images.png)

> Hello-world doit maintenant apparaître dans la liste des images locales.

### 9. Lancer le conteneur hello-world

```bash
docker run --rm hello-world
```

![docker run hello-world](./screenshots/Docker_run_--rm_Hello-World.png)

> Lance le conteneur hello-world. L'option --rm supprime automatiquement le conteneur après son exécution.
>
> **Résultat :** Affiche un message de bienvenue et s'arrête.

### 10. Nettoyage (optionnel)

**Arrêter tous les conteneurs :**

```bash
docker stop $(docker ps -q)
```

**Supprimer tous les conteneurs arrêtés :**

```bash
docker rm $(docker ps -a -q)
```

**Supprimer une image :**

```bash
docker rmi hello-world
# ou forcer la suppression
docker rmi -f docker/welcome-to-docker
```

---

## ✅ Job 01 - Résumé

| Étape              | Commande                                            | Résultat             |
| ------------------ | --------------------------------------------------- | -------------------- |
| Vérif installation | `docker --version`                                  | v29.2.1 ✅           |
| Infos système      | `docker info`                                       | Détails Docker ✅    |
| Conteneurs actifs  | `docker ps`                                         | Aucun au départ ✅   |
| Images présentes   | `docker images`                                     | Aucune au départ ✅  |
| Lancer Welcome     | `docker run -d -p 8088:80 docker/welcome-to-docker` | Conteneur démarré ✅ |
| Arrêter conteneur  | `docker stop <id>`                                  | Conteneur stoppé ✅  |
| Télécharger image  | `docker pull hello-world`                           | Image récupérée ✅   |
| Lancer Hello-World | `docker run --rm hello-world`                       | Message affiché ✅   |

---

## Job 02 : Deploying Mario game on docker container 🍄

**Objectif :** Déployer l'image du jeu Mario sur un conteneur Docker en utilisant les concepts fondamentaux.

**Prérequis :** Job 01 complété, Docker opérationnel.

### 1. Rechercher l'image Mario dans Docker Hub

```bash
docker search mario
```

> Cette commande affiche toutes les images Docker disponibles avec "mario" dans le nom. On cherche l'image `jordangrindrod/mario`.

![docker search mario](./screenshots/10-Docker_search_mario.png)

### 2. Télécharger l'image Mario

```bash
docker pull jordangrindrod/mario
```

> Télécharge l'image `jordangrindrod/mario` depuis Docker Hub vers la machine locale.

### 3. Vérifier que l'image est présente

```bash
docker images
```

> L'image `jordangrindrod/mario` doit maintenant apparaître dans la liste.

### 4. Lancer le conteneur Mario avec mapping de ports

```bash
docker run -itd -p 4545:8080 jordangrindrod/mario
```

![docker run -itd -p 4545:8080 jordangrindrod/mario](./screenshots/11.infinite_Mario_Start.png)

**Explications des options :**
- `-i` : mode interactif (interactive mode)
- `-t` : terminal
- `-d` : mode détaché (detach mode) - exécute le conteneur en arrière-plan
- `-p 4545:8080` : mappe le port 4545 de l'hôte au port 8080 du conteneur

> **Résultat :** Le conteneur démarre en arrière-plan et Mario est accessible à `http://localhost:4545`
![Mario Game Running](./screenshots/11.infinite_Mario_Start.png)



### 5. Vérifier que le conteneur est en cours d'exécution

```bash
docker ps
```

> Affiche le conteneur Mario en cours d'exécution avec sa configuration.

### 6. Inspecter les détails du conteneur

```bash
docker inspect <container_id>
```

> Affiche tous les détails du conteneur, notamment les ports exposés et les configurations.

### 7. Accéder au jeu Mario

Ouvrez un navigateur et allez à :
```
http://localhost:4545
```

![Mario Game Running](./screenshots/infinite_Mario_Start.png)

> Le jeu Mario est maintenant accessible et jouable dans le navigateur !

### 8. Arrêter le conteneur

```bash
docker stop <container_id>
```

> Arrête gracieusement le conteneur Mario.

### 9. Supprimer le conteneur

```bash
docker rm <container_id>
```

> Supprime le conteneur (mais l'image reste disponible pour relancer).

---

## ✅ Job 02 - Résumé

| Étape | Commande | Résultat |
|-------|----------|----------|
| Rechercher Mario | `docker search mario` | Images trouvées ✅ |
| Télécharger | `docker pull jordangrindrod/mario` | Image récupérée ✅ |
| Vérifier images | `docker images` | Mario présent ✅ |
| Lancer conteneur | `docker run -itd -p 4545:8080 jordangrindrod/mario` | Conteneur démarré ✅ |
| Vérifier état | `docker ps` | Conteneur actif ✅ |
| Accéder au jeu | `http://localhost:4545` | Mario jouable ✅ |
| Arrêter | `docker stop <id>` | Conteneur stoppé ✅ |
| Supprimer | `docker rm <id>` | Conteneur supprimé ✅ |

**Concepts clés :**
- Port mapping : `-p hostPort:containerPort`
- Mode interactif + terminal + détaché : `-itd`
- Docker Hub et les images publiques
- Gestion du cycle de vie d'un conteneur (run → stop → rm)
