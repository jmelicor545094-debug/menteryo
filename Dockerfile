FROM php:8.4-apache

# Install packages
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    zip \
    nodejs \
    npm \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip mbstring xml \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache rewrite
RUN a2enmod rewrite

# Change Apache port
RUN sed -i 's/Listen 80/Listen 10000/g' /etc/apache2/ports.conf
RUN sed -i 's/<VirtualHost \*:80>/<VirtualHost *:10000>/g' /etc/apache2/sites-available/000-default.conf

# Laravel public folder
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Allow .htaccess
RUN printf '<Directory /var/www/html/public>\n\
AllowOverride All\n\
Require all granted\n\
</Directory>\n' > /etc/apache2/conf-available/laravel.conf \
&& a2enconf laravel

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Working directory
WORKDIR /var/www/html

# Copy composer files first
COPY composer.json composer.lock ./

# Install dependencies WITHOUT scripts
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copy project files
COPY . .

# Create env
RUN cp .env.example .env

# Generate app key
RUN php artisan key:generate

# Run package discovery manually
RUN php artisan package:discover --ansi

# Install frontend dependencies
RUN npm install

# Build assets
RUN npm run build

# Storage link
RUN php artisan storage:link || true

# Clear caches
RUN php artisan optimize:clear || true

# Permissions
RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expose Render port
EXPOSE 10000

# Start Apache
CMD ["apache2-foreground"]
