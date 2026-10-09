FROM php:8.3-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install system dependencies and tools
RUN apk add --no-cache \
    bash \
    curl \
    git \
    unzip \
    linux-headers \
    ffmpeg \
    chromium \
    nss \
    freetype \
    harfbuzz \
    ca-certificates \
    ttf-freefont \
    nodejs \
    npm \
    supervisor \
    shadow \
    mysql-client

# Install PHP extensions installer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Install required PHP extensions
RUN install-php-extensions \
    pdo_mysql \
    redis \
    gd \
    intl \
    zip \
    bcmath \
    pcntl \
    exif \
    opcache

# Set Chromium environment variables for Puppeteer / Browsershot
ENV CHROME_BIN=/usr/bin/chromium-browser \
    CHROME_PATH=/usr/bin/chromium-browser \
    PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true

# Copy Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configure user
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Copy php configuration
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

# Ensure directories exist with correct permissions
RUN mkdir -p /var/www/html /var/log/supervisor /var/run/supervisor \
    && chown -R www-data:www-data /var/www/html /var/log/supervisor /var/run/supervisor

USER www-data

EXPOSE 9000

CMD ["php-fpm"]
