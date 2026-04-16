FROM php:8.2-cli

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git libpq-dev \
    && docker-php-ext-install zip pdo_pgsql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Instalar dependências SEM rodar scripts que pedem banco de dados
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Expor a porta 80
EXPOSE 80

# Comando para limpar cache e subir o servidor
CMD php artisan config:clear && php artisan serve --host=0.0.0.0 --port=80
