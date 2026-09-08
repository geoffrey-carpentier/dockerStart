# Image Nginx : alpine
FROM node:16-alpine

# Dossier de travail
WORKDIR /app

# Copie des fichiers package
COPY package*.json ./

# Installation des dépendances
RUN npm install

# Copie du projet
COPY . .

# Port exposé
EXPOSE 3000

# Lancement du serveur
CMD ["node", "server.js"]
