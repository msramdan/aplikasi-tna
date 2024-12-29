# Gunakan Ubuntu sebagai base image
FROM ubuntu:20.04

# Set timezone
ENV TZ=Asia/Jakarta
RUN apt-get update && apt-get install -y tzdata && \
    ln -sf /usr/share/zoneinfo/$TZ /etc/localtime && \
    echo $TZ > /etc/timezone

# Install dependencies
RUN apt-get install -y software-properties-common && \
    add-apt-repository ppa:ondrej/php && \
    apt-get update && apt-get install -y \
    php8.1 \
    php8.1-cli \
    php8.1-mysql \
    php8.1-xml \
    php8.1-mbstring \
    php8.1-bcmath \
    php8.1-curl \
    unzip \
    curl \
    supervisor

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Buat direktori kerja
WORKDIR /var/www/html

# Salin konfigurasi Supervisor
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Salin konfigurasi PHP
COPY docker/php.ini /etc/php/8.1/cli/php.ini

# Expose port
EXPOSE 8000

# Jalankan Supervisor
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
