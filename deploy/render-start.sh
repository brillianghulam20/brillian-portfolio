#!/usr/bin/env bash
set -euo pipefail

if [[ "${APP_KEY:-}" != base64:* ]]; then
    export APP_KEY="base64:$(php -r 'echo base64_encode(hash("sha256", getenv("APP_KEY"), true));')"
fi
export APP_URL="${APP_URL:-${RENDER_EXTERNAL_URL:-http://localhost}}"

mkdir -p storage/app/public/profile storage/app/public/resume
cp -n database/seeders/assets/profile.png storage/app/public/profile/brillian-ghulam.png || true
cp -n database/seeders/assets/CV-Brillian-Ghulam.pdf storage/app/public/resume/CV-Brillian-Ghulam.pdf || true

php artisan migrate --force
php artisan portfolio:install

php artisan optimize

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
