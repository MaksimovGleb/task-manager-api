FROM php:8.2-fpm

# Установка системных зависимостей и PHP расширений
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Установка Composer напрямую
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Создание рабочей директории
WORKDIR /var/www

# Копирование проекта
COPY . .

# Установка зависимостей проекта
RUN composer install --no-scripts --no-autoloader

# Генерация автозагрузки
RUN composer dump-autoload --optimize

# Права на папки и скрипт
RUN chown -R www-data:www-data storage bootstrap/cache && \
    sed -i 's/\r$//' docker-entrypoint.sh && \
    chmod +x docker-entrypoint.sh

EXPOSE 8000
ENTRYPOINT ["/var/www/docker-entrypoint.sh"]
