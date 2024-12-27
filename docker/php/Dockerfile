# Menggunakan image PHP 8.1.5 dengan Nginx dan ekstensi yang dibutuhkan
FROM php:8.1.5-fpm

# Install ekstensi yang diperlukan oleh Laravel
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libmcrypt-dev libxml2-dev zip git && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy file aplikasi ke dalam container
COPY ./app /var/www/html

# Set permission agar file aplikasi dapat dijalankan
RUN chown -R www-data:www-data /var/www/html
