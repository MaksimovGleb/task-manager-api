#!/bin/sh

# Создаем .env если его нет
[ ! -f .env ] && cp .env.example .env

# Создаем файл базы данных, если его нет
[ ! -f database/database.sqlite ] && touch database/database.sqlite

# Устанавливаем зависимости, если папка vendor пуста
[ ! -d vendor ] && composer install --no-interaction

# Генерируем ключ
php artisan key:generate --force

# Запускаем миграции
php artisan migrate --force

# Сидируем данные только если пользователей в базе еще нет
USER_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" | grep -oE '[0-9]+' | head -n 1)
if [ "$USER_COUNT" = "0" ] || [ -z "$USER_COUNT" ]; then
    echo "База пуста, запускаю сидеры..."
    php artisan db:seed --force
fi

# Запускаем тесты, принудительно переопределяя базу на :memory:
echo "Запуск тестов в изолированной памяти..."
DB_DATABASE=:memory: php artisan test --env=testing || echo "Тесты упали, но сервер запускается..."

# Запускаем сервер
exec php artisan serve --host=0.0.0.0 --port=8000
