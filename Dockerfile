FROM php:8.2-fpm

# Argumentos do build
ARG user=laravel
ARG uid=1000

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    mariadb-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criar usuário do sistema para rodar comandos do Composer e Artisan
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Definir diretório de trabalho
WORKDIR /var/www

# Copiar arquivos do projeto
COPY . /var/www

# Instalar dependências do PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Configurar permissões
RUN chown -R $user:www-data /var/www && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Mudar para o usuário criado
USER $user

# Expor porta 8000
EXPOSE 8000
