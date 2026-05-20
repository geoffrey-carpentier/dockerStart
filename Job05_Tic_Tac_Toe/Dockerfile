FROM trafex/php-nginx:latest

# Définir le répertoire de travail interne de l'image trafex
WORKDIR /var/www/html

# Copier les fichiers du jeu
COPY index.html /var/www/html/
COPY save.php /var/www/html/
COPY results.json /var/www/html/

# Forcer temporairement le passage en root pour modifier les droits d'écriture
USER root
RUN chmod 777 /var/www/html/results.json

# Rebasculer sur l'utilisateur sécurisé non-privilégié natif de l'image
USER nobody

EXPOSE 8080