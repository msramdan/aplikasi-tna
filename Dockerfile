# Gunakan image Ubuntu
FROM ubuntu:latest

# Install dependencies
RUN apt-get update && apt-get install -y \
    php-cli php-mbstring php-xml php-bcmath php-curl php-zip unzip curl git \
    nginx supervisor composer mysql-client && \
    apt-get clean

# Install Node.js dan npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Set direktori kerja
WORKDIR /var/www/html

# Salin semua file aplikasi
COPY . /var/www/html

# Install dependensi Laravel
RUN composer install --optimize-autoloader --no-dev && \
    npm install && npm run build

# Set permission untuk storage dan cache
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Salin konfigurasi nginx
COPY ./nginx.conf /etc/nginx/sites-available/default

# Expose port
EXPOSE 80

# Jalankan nginx dan supervisord
CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]
