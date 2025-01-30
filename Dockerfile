# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instala extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala Node.js (para Vite/Webpack)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && apt-get install -y nodejs

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos del proyecto
COPY . .

# Instala dependencias de Laravel y compila assets
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Establece permisos correctos
RUN chmod -R 777 storage bootstrap/cache

# Configura Apache para servir el directorio `public/`
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's|<Directory /var/www/html>|<Directory /var/www/html/public>|' /etc/apache2/sites-available/000-default.conf

# Habilita el módulo de reescritura de Apache
RUN a2enmod rewrite

# Expone el puerto 80
EXPOSE 80

# Comando de inicio
CMD ["apache2-foreground"]
