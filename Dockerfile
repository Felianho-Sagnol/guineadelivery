# Use the official PHP 8.0 image
FROM php:8.0.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Set working directory
WORKDIR /var/www/sagnodev/mylaravelapp

# Copy Laravel app files
COPY . .

# Expose port 9000 (used by PHP-FPM)
EXPOSE 9000