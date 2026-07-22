#!/bin/sh
set -e

cd /var/www/html

# Lien public/storage → storage/app/public (volume des uploads)
php artisan storage:link --force

# Caches de production (config, routes, vues)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Migrations : étape de déploiement contrôlée par défaut.
# Mettre RUN_MIGRATIONS=1 dans le .env pour les exécuter au démarrage.
if [ "${RUN_MIGRATIONS:-0}" = "1" ]; then
    echo "==> Migrations (RUN_MIGRATIONS=1)"
    php artisan migrate --force
fi

exec "$@"
