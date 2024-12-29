# Gunakan image PHP dengan Apache
FROM php:8.1-apache

# Install ekstensi PHP yang diperlukan
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# Set folder kerja ke root aplikasi Laravel
WORKDIR /var/www/html

# Salin file aplikasi Laravel ke container
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Jalankan Composer install untuk menginstal dependensi Laravel
RUN composer install --no-interaction

# Set izin untuk folder storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Set konfigurasi Apache untuk menjalankan aplikasi Laravel
COPY ./docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Ekspose port 80 untuk akses web
EXPOSE 80

# Perintah untuk menjalankan Apache di background
CMD ["apache2-foreground"]
