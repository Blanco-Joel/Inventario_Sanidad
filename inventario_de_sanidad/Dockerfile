# Usa PHP con CLI y FPM
FROM php:8.2-cli

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libxpm-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freetype --with-xpm \
    && docker-php-ext-install gd pdo pdo_mysql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar el directorio de trabajo
WORKDIR /var/www

# Copiar los archivos del proyecto
COPY . .

# Instalar dependencias de Laravel
RUN composer install

# Exponer el puerto 8000 (servidor de Laravel)
EXPOSE 8000

# Comando para iniciar Laravel
# --host=0.0.0.0  -> Permite acceder al servidor desde cualquier dispositivo en la red
# --port=8000     -> Usa el puerto 8000 (puedes cambiarlo si está en uso)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
