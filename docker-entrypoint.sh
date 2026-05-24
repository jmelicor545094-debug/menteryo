#!/bin/bash
set -e

# Render provides PORT env variable – default to 80 if not set
PORT="${PORT:-80}"

# Update Apache to listen on the correct port
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/*.conf

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run database migrations
php artisan migrate --force

# Cache configuration for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ">>> Starting Apache on port ${PORT}..."

# Start Apache in foreground
exec apache2-foreground
