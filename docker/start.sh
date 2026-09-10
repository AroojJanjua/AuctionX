#!/bin/sh
set -e

cd /var/www/html

# Wait isn't needed here since migrations are run manually via Render's Shell tab,
# but always refresh cached config/routes/views on boot so env var changes take effect.
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ensure the public/storage symlink exists (safe to run repeatedly)
php artisan storage:link || true

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
