# Job 05 - Tic Tac Toe : Docker et Volumes 🎮

**Formation Docker - La Plateforme DWWM**

**Objectif :** Créer une application Tic Tac Toe dockerisée avec persistance des résultats via un volume Docker.

**Compétences visées :**

- ✅ Créer et exploiter une image Docker
- ✅ Utiliser les volumes Docker pour la persistance
- ✅ Configurer Nginx + PHP dans Docker
- ✅ Mapper des ports et des volumes

---

## 📋 Résumé du Projet

| Aspect           | Détail                                        |
| ---------------- | --------------------------------------------- |
| **Objectif**     | Application Tic Tac Toe accessible via Docker |
| **Image Docker** | Nginx + PHP-FPM                               |
| **Port**         | 8080 (externe) → 80 (conteneur)               |
| **Volume**       | `game-results` pour persister `results.json`  |
| **Backend**      | save.php (sauvegarde les résultats du jeu)    |
| **Frontend**     | index.html (interface du jeu en JavaScript)   |

---

## 📁 Structure du Projet

```
Tic_Tac_Toe/
├── README.md                 # Ce fichier (documentation)
├── Dockerfile                # Configuration Docker
├── index.html                # Interface du jeu (HTML + JS)
├── save.php                  # Backend (PHP) - Sauvegarde les résultats
├── results.json              # Fichier de stockage des résultats
├── screenshots/              # Captures d'écran des étapes
│   ├── 01-project-structure.png
│   ├── 02-dockerfile-create.png
│   ├── ...
│   └── 15-results-json-final.png
└── data/                     # Dossier de travail (local)
```

---

## 🚀 Étapes du Projet

### Phase 1 : Préparation des Fichiers

#### **Étape 1 : Vérifier la structure du projet**

```bash
cd Tic_Tac_Toe
ls -la
```

**Résultat attendu :**

- ✅ `index.html` - Page du jeu
- ✅ `save.php` - Backend PHP
- ✅ `results.json` - Fichier de stockage
- ✅ `Dockerfile` - Configuration Docker

**Screenshot :** [À intégrer]
![Vérification de la structure du projet](./screenshots/01-project-structure.png)

---

#### **Étape 2 : Vérifier le contenu du Dockerfile**

```bash
cat Dockerfile
```

**Contenu clé du Dockerfile :**

- Image de base : `nginx:alpine`
- Installation PHP + extensions
- Copie des fichiers (index.html, save.php, results.json)
- Configuration Nginx pour PHP-FPM
- Exposition du port 80
- Commande démarrage : PHP-FPM + Nginx

**Screenshot :** [À intégrer]
![Contenu du Dockerfile](./screenshots/02-dockerfile-create.png)

---

### Phase 2 : Construction de l'Image Docker

#### **Étape 3 : Construire l'image Docker**

```bash
docker build -t tic-tac-toe-app .
```

**Résultat :** Image construite avec succès ✅

**Screenshot :** [À intégrer]
![Construction de l'image](./screenshots/03-docker-build.png)

---

#### **Étape 4 : Vérifier que l'image est créée**

```bash
docker images | grep tic-tac-toe
```

**Résultat :** Image `tic-tac-toe-app` visible dans la liste ✅

**Screenshot :** [À intégrer]
![Vérification de l'image](./screenshots/04-docker-images.png)

---

### Phase 3 : Gestion du Volume

#### **Étape 5 : Créer le volume Docker nommé "game-results"**

```bash
docker volume create game-results
```

**Résultat :** Volume créé avec succès ✅

**Screenshot :** [À intégrer]
![Création du volume](./screenshots/05-docker-volume-create.png)

---

#### **Étape 6 : Vérifier la création du volume**

```bash
docker volume ls
```

**Résultat :** Volume `game-results` visible dans la liste ✅

```
DRIVER    VOLUME NAME
local     game-results
```

**Screenshot :** [À intégrer]
![Vérification du volume](./screenshots/06-docker-volume-ls.png)

---

#### **Étape 7 : Inspecter le volume**

```bash
docker volume inspect game-results
```

**Résultat :** Affiche le chemin de montage du volume sur l'hôte ✅

**Screenshot :** [À intégrer]
![Inspection du volume](./screenshots/07-docker-volume-inspect.png)

---

### Phase 4 : Lancer le Conteneur

#### **Étape 8 : Lancer le conteneur avec le volume**

```bash
docker run -d -p 8080:80 -v game-results:/usr/share/nginx/html --name tic-tac-toe-container tic-tac-toe-app
```

**Explications :**

- `-d` = Mode détaché (arrière-plan)
- `-p 8080:80` = Mapper port 8080 (hôte) → 80 (conteneur)
- `-v game-results:/usr/share/nginx/html` = Monter le volume
- `--name tic-tac-toe-container` = Nommer le conteneur
- `tic-tac-toe-app` = Image à utiliser

**Résultat :** Conteneur démarré avec succès ✅

**Screenshot :** [À intégrer]
![Lancement du conteneur](./screenshots/08-docker-run.png)

---

#### **Étape 9 : Vérifier que le conteneur est actif**

```bash
docker ps
```

**Résultat :** Conteneur `tic-tac-toe-container` visible et actif ✅

**Screenshot :** [À intégrer]
![Vérification du conteneur](./screenshots/09-docker-ps.png)

---

### Phase 5 : Tester l'Application

#### **Étape 10 : Accéder au jeu dans le navigateur**

```
http://localhost:8080
```

**Résultat :**

- ✅ Page Tic Tac Toe s'affiche
- ✅ Jeu fonctionnel
- ✅ Grille 3x3 visible

**Screenshot :** [À intégrer]
![Page Tic Tac Toe accueil](./screenshots/10-tictactoe-page.png)

---

#### **Étape 11 : Jouer une première partie**

1. Cliquer sur les cases pour jouer
2. X commence, puis O
3. Résultats sauvegardés automatiquement

**Résultat :**

- ✅ Jeu fonctionnel
- ✅ Messages affichés ("C'est au tour de...")
- ✅ Résultat sauvegardé dans results.json

**Screenshot :** [À intégrer]
![Première partie de Tic Tac Toe](./screenshots/11-tictactoe-game1.png)

---

#### **Étape 12 : Jouer plusieurs parties**

Jouer 2-3 parties additionnelles pour générer des résultats.

**Résultat :** Multiple résultats enregistrés ✅

**Screenshot :** [À intégrer]
![Plusieurs parties jouées](./screenshots/12-tictactoe-multiple-games.png)

---

### Phase 6 : Vérifier la Persistance

#### **Étape 13 : Afficher le contenu de results.json via le terminal**

```bash
docker exec tic-tac-toe-container cat /usr/share/nginx/html/results.json
```

**Résultat :** Affiche les résultats de toutes les parties en JSON ✅

```json
[
  {
    "winner": "X",
    "timestamp": "2024-05-19 14:32:45"
  },
  {
    "winner": "Draw",
    "timestamp": "2024-05-19 14:35:22"
  },
  {
    "winner": "O",
    "timestamp": "2024-05-19 14:36:10"
  }
]
```

**Screenshot :** [À intégrer]
![Contenu de results.json](./screenshots/13-results-json-cat.png)

---

#### **Étape 14 : Afficher le contenu du volume via Docker Desktop**

1. Ouvrir Docker Desktop
2. Aller dans l'onglet "Volumes"
3. Sélectionner `game-results`
4. Vérifier les fichiers présents

**Résultat :**

- ✅ Volume `game-results` visible
- ✅ Fichiers `results.json` et `save.php` présents

**Screenshot :** [À intégrer]
![Docker Desktop - Volumes](./screenshots/14-docker-desktop-volumes.png)

---

#### **Étape 15 : Arrêter le conteneur et vérifier la persistance**

```bash
docker stop tic-tac-toe-container
```

**Résultat :** Conteneur arrêté ✅

**Screenshot :** [À intégrer]
![Arrêt du conteneur](./screenshots/15-docker-stop.png)

---

#### **Étape 16 : Relancer le conteneur**

```bash
docker run -d -p 8080:80 -v game-results:/usr/share/nginx/html --name tic-tac-toe-container-2 tic-tac-toe-app
```

**Résultat :** Nouveau conteneur lancé ✅

**Screenshot :** [À intégrer]
![Relancement du conteneur](./screenshots/16-docker-run-again.png)

---

#### **Étape 17 : Vérifier que les résultats persiste**

```bash
docker exec tic-tac-toe-container-2 cat /usr/share/nginx/html/results.json
```

**Résultat :**

- ✅ Les résultats précédents sont toujours présents
- ✅ Volume a permis la persistance ✅

**Screenshot :** [À intégrer]
![Vérification de la persistance](./screenshots/17-results-persisted.png)

---

### Phase 7 : Commandes Avancées

#### **Étape 18 : Afficher le contenu du conteneur**

Via terminal :

```bash
docker exec tic-tac-toe-container ls -la /usr/share/nginx/html
```

Via Docker Desktop :

- Sélectionner le conteneur
- Onglet "Exec" ou afficher les fichiers

**Screenshot :** [À intégrer]
![Contenu du conteneur](./screenshots/18-container-contents.png)

---

#### **Étape 19 : Afficher le contenu du volume**

Via terminal :

```bash
docker volume inspect game-results
docker run -v game-results:/data alpine ls -la /data
```

Via Docker Desktop :

- Volumes → game-results → Afficher les fichiers

**Screenshot :** [À intégrer]
![Contenu du volume](./screenshots/19-volume-contents.png)

---

### Phase 8 : Nettoyage

#### **Étape 20 : Arrêter et supprimer les conteneurs**

```bash
docker stop tic-tac-toe-container tic-tac-toe-container-2
docker rm tic-tac-toe-container tic-tac-toe-container-2
```

**Résultat :** Conteneurs supprimés ✅

---

#### **Étape 21 : Supprimer l'image**

```bash
docker rmi tic-tac-toe-app
```

**Résultat :** Image supprimée ✅

---

#### **Étape 22 : Le volume persiste toujours**

```bash
docker volume ls | grep game-results
```

**Résultat :** Volume toujours présent ✅

---

## 📊 Résultats Finaux

### Contenu du fichier results.json

**Après plusieurs parties jouées :**

```json
[
  {
    "winner": "X",
    "timestamp": "2024-05-19 10:15:32"
  },
  {
    "winner": "O",
    "timestamp": "2024-05-19 10:16:45"
  },
  {
    "winner": "Draw",
    "timestamp": "2024-05-19 10:17:22"
  }
]
```

**Screenshot :** [À intégrer - Afficher le contenu final de results.json]
![Résultats finaux - results.json](./screenshots/final-results-json.png)

---

## ✅ Compétences Acquises

| Compétence                              | État |
| --------------------------------------- | ---- |
| Créer une image Docker personnalisée    | ✅   |
| Utiliser Nginx + PHP dans Docker        | ✅   |
| Créer et utiliser des volumes nommés    | ✅   |
| Mapper des ports Docker                 | ✅   |
| Vérifier la persistance des données     | ✅   |
| Afficher le contenu du conteneur        | ✅   |
| Afficher le contenu du volume           | ✅   |
| Gérer le cycle de vie (run → stop → rm) | ✅   |
| Documenter un projet Docker             | ✅   |

---

## 🎯 Concepts Clés Apprises

### Volumes Docker

**Qu'est-ce qu'un volume ?**

- Mécanisme pour persister les données en dehors du conteneur
- Survit à la suppression du conteneur
- Peut être monté sur plusieurs conteneurs

**Types de volumes :**

- **Volumes nommés** : `docker volume create game-results`
- **Volumes anonymes** : Créés automatiquement
- **Bind mounts** : Lier des chemins du système hôte

### Persistance des Données

**Problème :** Données perdues à la suppression du conteneur

**Solution :** Utiliser des volumes

**Flux :**

1. Application génère données (results.json)
2. Données stockées dans le volume
3. Conteneur supprimé → Volume persiste
4. Nouveau conteneur monté sur le même volume → Données restaurées

### Configuration Nginx + PHP

**Architecture :**

```
Client HTTP
    ↓
Nginx (port 80) [reverse proxy]
    ↓
PHP-FPM (port 9000) [exécution PHP]
    ↓
save.php → results.json (dans le volume)
```

---

## 📚 Références

- [Documentation Docker Volumes](https://docs.docker.com/storage/volumes/)
- [Documentation Nginx](https://nginx.org/)
- [Documentation PHP-FPM](https://www.php.net/manual/en/install.fpm.php)
- [Image Nginx Docker Hub](https://hub.docker.com/_/nginx)

---

## 📝 Résumé de la Session

**Objectifs accomplies :**

- ✅ Image Docker créée avec Nginx + PHP
- ✅ Volume `game-results` créé et utilisé
- ✅ Application jouable via http://localhost:8080
- ✅ Résultats persistés dans results.json
- ✅ Persistance vérifiée après restart

**Fichiers créés :**

- ✅ index.html (jeu)
- ✅ save.php (backend)
- ✅ results.json (stockage)
- ✅ Dockerfile (configuration)
- ✅ README.md (documentation)

**Compétences validées :**

- ✅ Création d'images Docker
- ✅ Utilisation des volumes
- ✅ Configuration Nginx + PHP
- ✅ Gestion des conteneurs

---

**Formation Docker - La Plateforme DWWM** 🚀
Jour 3 - Job 05 - Tic Tac Toe avec Volumes ✅
