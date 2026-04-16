FROM php:8.2-cli

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git \
    && docker-php-ext-install zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Instalar dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Expor a porta 80
EXPOSE 80

# Comando para rodar o servidor sem Nginx
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
