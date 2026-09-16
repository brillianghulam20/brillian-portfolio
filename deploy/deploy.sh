#!/usr/bin/env bash
set -euo pipefail

APP_DIR="${APP_DIR:-/var/www/brillian-portfolio/current}"
cd "$APP_DIR"

composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan portfolio:install
php artisan storage:link
php artisan optimize

chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache

sudo systemctl reload php8.5-fpm
sudo systemctl reload nginx

curl --fail --silent --show-error "${APP_URL:-http://127.0.0.1}/up"
