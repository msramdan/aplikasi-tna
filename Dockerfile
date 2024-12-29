# Gunakan base image Ubuntu
FROM ubuntu:22.04

# Install dependencies
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    supervisor \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    default-mysql-client \
    && apt-get clean

# Install PHP dan ekstensi
RUN apt-get update && apt-get install -y php-cli php-mbstring php-xml php-bcmath php-zip php-curl php-tokenizer php-pdo php-mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Salin file Laravel ke container
COPY . .

# Install dependencies Laravel
RUN composer install --no-scripts --no-dev --prefer-dist

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Jalankan Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
