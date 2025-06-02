# FROM php:8.2-apache
# RUN docker-php-ext-install pdo pdo_mysql
# COPY . /var/www/html/

FROM php:8.2-cli

# Install required extensions
RUN apt-get update && apt-get install -y unzip curl libzip-dev && docker-php-ext-install zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy Laravel files
COPY . /var/www/html

# Install Laravel dependencies
RUN composer install

# Expose Laravel port
EXPOSE 8000

# Run Laravel dev server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
