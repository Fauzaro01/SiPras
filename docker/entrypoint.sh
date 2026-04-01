#!/usr/bin/env sh
set -e

cd /var/www

if [ ! -f .env ] && [ -f .env.example ]; then
  cp .env.example .env
fi

if ! grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
  php artisan key:generate --force --no-interaction
fi

if [ "${DB_CONNECTION}" = "sqlite" ]; then
  mkdir -p /var/www/storage/database
  touch /var/www/storage/database/database.sqlite
fi

php artisan storage:link || true

if [ "${RUN_MIGRATIONS}" = "true" ]; then
  php artisan migrate --force --no-interaction
fi

php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

exec "$@"
