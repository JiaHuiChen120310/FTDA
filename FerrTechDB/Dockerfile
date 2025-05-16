FROM php:8.2-apache

# Install required PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache rewrite module (optional)
RUN a2enmod rewrite

# Set working directory (handled by docker-compose via volumes)
WORKDIR /var/www/html

# (Optional) Copy custom Apache config if needed
# COPY apache.conf /etc/apache2/sites-available/000-default.conf
