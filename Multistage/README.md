# Job 05 - Dockerfile Multi-stage Build 🐳

**Optimiser ses images Docker pour la production**

Formation DWWM - La Plateforme

---

## 📌 Objectif

Apprendre à créer des images Docker **ultra-légères** grâce au **multi-stage build**. Cette technique est utilisée en production pour réduire la taille des images de **90%** !

### ⚠️ Le Problème

Une image Node.js classique avec les `devDependencies` peut faire **1 Go+**. En production, on n'a pas besoin de tout ça :

- node_modules complets (dev + prod)
- Code source TypeScript (avant compilation)
- Outils de build (tsc, ts-node, etc.)
- Fichiers temporaires

### ✨ La Solution : Multi-stage Build

On utilise **plusieurs FROM** pour séparer les étapes :

1. **Étape 1 : Builder** (image temporaire) - contient tout pour compiler
2. **Étape 2 : Production** (image finale) - contient UNIQUEMENT le nécessaire

---

## 🎯 Ce que tu vas apprendre

✅ Comprendre le problème des images trop lourdes  
✅ Utiliser plusieurs FROM dans un Dockerfile  
✅ Séparer le build de l'exécution avec `--from=builder`  
✅ Créer une image de production optimisée  
✅ Comparer les tailles et mesurer les gains

---

## 📁 Structure du Projet

```
Multistage/
├── src/
│   └── index.ts              # API TypeScript simple (Hello World)
├── package.json              # Dépendances Node.js
├── tsconfig.json             # Configuration TypeScript
├── Dockerfile                # Multi-stage (OPTIMISÉ)
├── Dockerfile-simple         # Classique (LOURD - pour comparaison)
├── README.md                 # Cette documentation
└── screenshots/              # Captures d'écran
    ├── 1-structure.png
    ├── 2-docker-build-simple.png
    ├── 3-docker-build-multistage.png
    ├── 4-docker-images-comparison.png
    ├── 5-api-running-simple.png
    └── 6-api-running-multistage.png
```

---

## 🛠️ ÉTAPE 1 : Initialiser le Projet

### Commandes à entrer :

```bash
cd d:\TOOLS\LARAGON\www\dockerStart
mkdir Multistage
cd Multistage
npm init -y
npm install express
npm install -D typescript ts-node @types/node @types/express
npx tsc --init
mkdir src
```

**📸 Screenshot 1 :** Structure du dossier et fichiers créés  
_Commande : `dir` ou `ls -la`_

---

## 📄 ÉTAPE 2 : Créer les Fichiers Source

### src/index.ts

API TypeScript simple qui répond "Hello World" sur le port 3000 :

```typescript
import express from "express";

const app = express();
const PORT = 3000;

app.get("/", (req, res) => {
  res.send("Hello World from TypeScript API!");
});

app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
```

### package.json

Configuration Node.js avec les scripts de build et démarrage :

```json
{
  "name": "api-multistage",
  "version": "1.0.0",
  "description": "TypeScript API with multistage build",
  "main": "dist/index.js",
  "scripts": {
    "build": "tsc",
    "start": "node dist/index.js",
    "dev": "ts-node src/index.ts"
  },
  "dependencies": {
    "express": "^4.22.2"
  },
  "devDependencies": {
    "@types/express": "^4.17.17",
    "@types/node": "^20.3.1",
    "ts-node": "^10.9.1",
    "typescript": "^5.1.3"
  }
}
```

---

## 🐳 ÉTAPE 3 : Créer les Dockerfiles

### Dockerfile-simple (CLASSIQUE - LOURD ⚠️)

Version simple SANS optimisation, pour comparer les tailles :

```dockerfile
FROM node:18

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY src ./src
COPY tsconfig.json .

RUN npm run build

EXPOSE 3000

CMD ["node", "dist/index.js"]
```

⚠️ **Problème :** Cette image contient TOUT :

- Tous les node_modules (dev + prod)
- Outils de build (tsc, ts-node, etc.)
- Code TypeScript source (inutile après compilation)

---

### Dockerfile (MULTI-STAGE - OPTIMISÉ ✨)

Version optimisée avec deux étapes séparées :

```dockerfile
# ====================================
# ÉTAPE 1 : BUILD (image temporaire)
# ====================================
FROM node:18-alpine AS builder

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY src ./src
COPY tsconfig.json .

RUN npm run build

# ====================================
# ÉTAPE 2 : PRODUCTION (image finale)
# ====================================
FROM node:18-alpine AS production

WORKDIR /app

# Copier UNIQUEMENT le build depuis l'étape builder
COPY --from=builder /app/dist ./dist
COPY --from=builder /app/package*.json ./

# Installer SEULEMENT les dépendances de production
RUN npm install --production

# Utilisateur non-root (sécurité)
USER node

EXPOSE 3000

CMD ["node", "dist/index.js"]
```

**Optimisations :**

- `alpine` au lieu de versions complètes (ultra-légères)
- Stage `builder` : utilisé temporairement, puis jeté
- Stage `production` : ne copie que le build compilé
- `npm install --production` : sans devDependencies
- `USER node` : sécurité (pas de root)

---

## 🚀 ÉTAPE 4 : Builder les Images

### 4.1 - Build l'image CLASSIQUE (simple)

```bash
docker build -f Dockerfile-simple -t api-simple .
```

**📸 Screenshot 2 :** Sortie du build classique  
_Montre le processus de compilation_

---

### 4.2 - Build l'image MULTI-STAGE (optimisée)

```bash
docker build -f Dockerfile -t api-prod .
```

**📸 Screenshot 3 :** Sortie du build multi-stage  
_Montre les deux étapes séparées (builder + production)_

---

## 📊 ÉTAPE 5 : Comparer les Tailles

### Commande :

```bash
docker images
```

**📸 Screenshot 4 : COMPARAISON DES TAILLES** ⭐⭐⭐

Voir les deux images côte à côte :

- `api-simple` : Image classique LOURDE
- `api-prod` : Image multi-stage LÉGÈRE

### Résultat attendu :

| Image        | Taille      | Réduction       |
| ------------ | ----------- | --------------- |
| `api-simple` | ~400-600 MB | 100% (baseline) |
| `api-prod`   | ~100-150 MB | **75-80%** ✨   |

---

## ✅ ÉTAPE 6 : Tester les Images

### 6.1 - Lancer l'image CLASSIQUE

```bash
docker run -d -p 3001:3000 --name api-simple-container api-simple
```

Vérifier dans le navigateur : **http://localhost:3001**

**📸 Screenshot 5 :** API classique fonctionnant  
_Affiche "Hello World from TypeScript API!"_

---

### 6.2 - Lancer l'image MULTI-STAGE

```bash
docker run -d -p 3002:3000 --name api-prod-container api-prod
```

Vérifier dans le navigateur : **http://localhost:3002**

**📸 Screenshot 6 :** API multi-stage fonctionnant  
_Affiche "Hello World from TypeScript API!"_

---

## 🧹 Nettoyage

### Arrêter et supprimer les conteneurs :

```bash
docker stop api-simple-container api-prod-container
docker rm api-simple-container api-prod-container
```

### Supprimer les images (optionnel) :

```bash
docker rmi api-simple api-prod
```

---

## 📝 Résumé des Commandes Clés

```bash
# Initialisation
npm init -y
npm install express
npm install -D typescript ts-node @types/node @types/express

# Build
docker build -f Dockerfile-simple -t api-simple .
docker build -f Dockerfile -t api-prod .

# Voir les tailles
docker images

# Tester
docker run -d -p 3001:3000 --name api-simple-container api-simple
docker run -d -p 3002:3000 --name api-prod-container api-prod

# Nettoyage
docker stop api-simple-container api-prod-container
docker rm api-simple-container api-prod-container
docker rmi api-simple api-prod
```

---

## 💡 Points Clés à Retenir

1. **Multi-stage = 2+ FROM** : Builder (temporaire) → Production (final)
2. **COPY --from=builder** : Copie depuis une étape précédente
3. **alpine = ultra-léger** : Réduit de 75-80%
4. **npm install --production** : Sans devDependencies en prod
5. **USER node** : Sécurité (pas de root)

---

## 🎓 Concepts Appris

- ✅ Problème des images trop lourdes
- ✅ Concept du multi-stage build
- ✅ Optimisation avec alpine
- ✅ Séparation build/production
- ✅ Mesure et comparaison des tailles

---

## 📌 État du Job 05

✅ API TypeScript créée  
✅ Dockerfile classique créé  
✅ Dockerfile multi-stage créé  
✅ Images buildées et testées  
⏳ Screenshots à prendre  
⏳ Commit à faire

---

**Formation DWWM - La Plateforme** 🚀
