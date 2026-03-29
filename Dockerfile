# Use the official PHP image with Apache
FROM php:8.2-apache

# Install PostgreSQL dev tool and the PHP pdo_pgsql extension
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Enable Apache mod_rewrite for your .htaccess file
RUN a2enmod rewrite

# Copy your project files to the web server directory
COPY . /var/www/html/

# Expose port 80
EXPOSE 80