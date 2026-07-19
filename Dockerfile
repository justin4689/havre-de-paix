FROM php:8.4-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
        curl \
        git \
        libicu-dev \
        libzip-dev \
        unzip \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        intl \
        pcntl \
        pdo_mysql \
        zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["entrypoint.sh"]
# Serveur PHP intégré lancé directement (équivalent de `artisan serve`) :
# `artisan serve` ne transmet qu'une liste blanche de variables d'environnement
# à son processus enfant, ce qui ferait perdre les DB_* définies par compose.
# Le routeur server.php prend getcwd() comme racine publique, d'où le cd public.
CMD ["sh", "-c", "cd public && exec php -S 0.0.0.0:8000 ../vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php"]
