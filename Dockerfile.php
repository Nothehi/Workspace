FROM php:8.4-cli

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    nano \
    zip \
    unzip \
    libgd-dev \
    libicu-dev \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libzip-dev \
    libxml2-dev \
    libmcrypt-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    build-essential \
    libssl-dev \
    zlib1g-dev \
    libwebp-dev \
    libxpm-dev

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install zip soap mbstring exif bcmath sockets pcntl pdo pdo_pgsql intl \
    && docker-php-ext-configure intl \
    && docker-php-ext-enable intl

RUN docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure Git (fix ownership issues)
RUN git config --global --add safe.directory '*'

# Install system dependencies if needed
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app