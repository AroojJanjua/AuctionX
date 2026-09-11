#!/bin/sh
set -e

cd /var/www/html

echo "=== [start.sh] Booting AuctionX ==="
echo "=== [start.sh] Testing database connectivity (30s timeout) ==="
timeout 30 php artisan db:show || echo "!!! [start.sh] DB connectivity check failed or timed out !!!"

echo "=== [start.sh] Running migrations (60s timeout) ==="
# Render's free tier has no SSH/Shell access, so migrations must run
# automatically on every container boot instead of manually.
# Laravel's migrator skips migrations that already ran, so this is
# safe to run every time the app starts or redeploys.
timeout 60 php artisan migrate --force
echo "=== [start.sh] Migrations finished ==="

# Refresh cached config/routes/views on boot so env var changes take effect.
echo "=== [start.sh] Caching config/routes/views ==="
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ensure the public/storage symlink exists (safe to run repeatedly)
php artisan storage:link || true

echo "=== [start.sh] Starting nginx + php-fpm via supervisord ==="
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
