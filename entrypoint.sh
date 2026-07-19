#!/bin/sh
set -e

# Le service queue démarre avec SKIP_SETUP=1 : l'app a déjà tout préparé.
if [ "${SKIP_SETUP:-0}" != "1" ]; then
    if [ ! -f .env ]; then
        echo "==> Création du .env depuis .env.example"
        cp .env.example .env
    fi

    echo "==> composer install"
    composer install --no-interaction --prefer-dist

    if ! grep -q '^APP_KEY=.\{5,\}' .env; then
        echo "==> Génération de APP_KEY"
        php artisan key:generate --force --no-interaction
    fi

    echo "==> Lien de stockage public (photos uploadées)"
    php artisan storage:link --force

    echo "==> Migrations"
    tries=0
    until php artisan migrate --force; do
        tries=$((tries + 1))
        if [ "$tries" -ge 5 ]; then
            echo "==> Échec des migrations après 5 tentatives" >&2
            exit 1
        fi
        echo "==> Base de données pas encore prête, nouvel essai dans 3s..."
        sleep 3
    done

    USER_COUNT=$(php artisan tinker --execute='echo \App\Models\User::count();' 2>/dev/null | tr -d '[:space:]' || true)
    if [ "$USER_COUNT" = "0" ]; then
        echo "==> Base vide : exécution des seeders"
        php artisan db:seed --force
    fi
fi

exec "$@"
