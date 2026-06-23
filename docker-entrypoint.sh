#!/bin/sh

# Создаем .env если его нет
[ ! -f .env ] && cp .env.example .env

# Создаем файл базы данных, если его нет
[ ! -f database/database.sqlite ] && touch database/database.sqlite

# Устанавливаем зависимости, если папка vendor пуста
[ ! -d vendor ] && composer install --no-interaction

# Генерируем ключ, обновляем базу и запускаем тесты
php artisan key:generate --force
php artisan migrate:fresh --seed --force
php artisan test || echo "Тесты упали, но сервер запускается..."

# Запускаем сервер
exec php artisan serve --host=0.0.0.0 --port=8000
