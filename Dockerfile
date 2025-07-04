FROM php:8.2-fpm

# Установка системных зависимостей
RUN apt-get update \
    && apt-get install -y \
        git \
        curl \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
        npm \
        nodejs \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Установка Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Копирование файлов приложения
COPY . /var/www/html

# Установка прав
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

WORKDIR /var/www/html

# Установка зависимостей Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Установка node-зависимостей (если есть package.json)
RUN if [ -f package.json ]; then npm install && npm run build; fi

EXPOSE 9000
CMD ["php-fpm"] 