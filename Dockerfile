# Use the official PHP image with PHP 8.0
FROM php:8.2-cli

# Install git, required for composer
RUN apt-get update && apt-get install -y git

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set the working directory inside the container
WORKDIR /app