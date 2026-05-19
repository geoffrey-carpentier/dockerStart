# Utiliser une image Nginx légère
FROM nginx:alpine

# Installer PHP et les extensions nécessaires
RUN apk add --no-cache php php-fpm php-json

# Copier la configuration Nginx personnalisée
RUN mkdir -p /etc/nginx/conf.d && \
    echo 'server { \
        listen 80; \
        server_name localhost; \
        root /usr/share/nginx/html; \
        index index.html index.php; \
        location ~ \.php$ { \
            fastcgi_pass 127.0.0.1:9000; \
            fastcgi_index index.php; \
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
            include fastcgi_params; \
        } \
    }' > /etc/nginx/conf.d/default.conf

# Copier les fichiers du jeu dans le conteneur
COPY index.html /usr/share/nginx/html/
COPY save.php /usr/share/nginx/html/
COPY results.json /usr/share/nginx/html/

# Créer un volume pour la persistance des résultats
RUN mkdir -p /app/data && \
    chmod 777 /app/data && \
    chmod 777 /usr/share/nginx/html/results.json

# Exposer le port 80
EXPOSE 80

# Commande de démarrage (PHP-FPM + Nginx)
CMD php-fpm -D && nginx -g "daemon off;"
