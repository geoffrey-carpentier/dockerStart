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
