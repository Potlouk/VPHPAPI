# Use the official PHP image as the base image
FROM php:8.1-cli

# Synchronize system time and install dependencies
RUN apt-get update && apt-get install -y \
    tzdata \
    && ln -fs /usr/share/zoneinfo/Etc/UTC /etc/localtime \
    && dpkg-reconfigure --frontend noninteractive tzdata \
    && apt-get install -y \
    libbrotli-dev \
    libssl-dev \
    pkg-config \
    && pecl install swoole \
    && docker-php-ext-enable swoole \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo_mysql

# Set the working directory
WORKDIR /var/www

# Copy the current directory contents into the container at /var/www
COPY . /var/www

# Expose port 6060 for Swoole
EXPOSE 6060

# Command to run the Swoole server
CMD ["php", "/var/www/src/server.php"]