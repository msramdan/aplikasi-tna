# Menggunakan Ubuntu base image
FROM ubuntu:20.04

# Install PHP, PHP extensions, dan dependencies
RUN apt-get update && apt-get install -y \
    software-properties-common \
    curl \
    unzip \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    php8.1-cli \
    php8.1-fpm \
    php8.1-mysql \
    php8.1-xml \
    php8.1-mbstring \
    php8.1-bcmath \
    php8.1-curl \
    php8.1-zip

# Set environment variables
ENV TZ=Asia/Jakarta

# Install Composer (PHP dependency manager)
RUN curl -sS https://getcomposer.org/installer | php8.1 -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Salin aplikasi Laravel ke container
COPY . .

# Install dependencies Laravel
RUN composer install --no-dev --optimize-autoloader

# Open port 8000 untuk PHP built-in server
EXPOSE 8000

# Command untuk menjalankan PHP built-in server
CMD ["php8.1", "-S", "0.0.0.0:8000", "-t", "public"]
