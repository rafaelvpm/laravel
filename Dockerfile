FROM php:8.2-cli

# Instalar drivers do Postgres (essencial para o seu pg_connect)
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql

WORKDIR /app
COPY . .

# Inicia o servidor embutido do PHP na raiz
CMD php -S 0.0.0.0:80
