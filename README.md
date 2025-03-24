# Infrastructure Setup and Testing Guide

This document provides instructions for setting up and testing the Laravel/Vue infrastructure using Docker.

## Prerequisites

- Docker and Docker Compose installed
- Git repository cloned to your local machine

## Quick Setup

### 1. Build and Start the Infrastructure

```bash
docker-compose up -d --build
```

### 2. Configure the Environment

Create your environment file from the example:

```bash
cp src/.env_example src/.env
```

### 3. Install Dependencies and Initialize the Application

```bash
# Install PHP dependencies
docker exec iz-laravel10-vue3-app composer install

# Generate application key
docker exec iz-laravel10-vue3-app php artisan key:generate

# Set up the database
docker exec iz-laravel10-vue3-app php artisan migrate:fresh

# Install frontend dependencies
docker exec iz-laravel10-vue3-node npm install

# Start Vite development server
docker exec iz-laravel10-vue3-node npm run dev
```

## Verification Steps

### Verify Container Status

```bash
docker ps
```

### Verify Node Installation

```bash
docker exec iz-laravel10-vue3-node node --version
```

### Verify Database Connection

```bash
docker exec -it iz-laravel10-vue3-db psql -U laravel -d laravel
```

To exit the database prompt, type:
```
\q
```

## Troubleshooting

### Permissions Issues

If you encounter permissions problems with storage directories, follow these steps:

1. Create a startup script:

```bash
cat > docker/php/startup.sh << 'EOF'
#!/bin/bash
# Fix storage permissions
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage

# Start PHP-FPM
exec php-fpm
EOF

chmod +x docker/php/startup.sh
```

2. Append the following to your Dockerfile:

```dockerfile
# Copy startup script
COPY ./startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

# Set entrypoint
ENTRYPOINT ["/usr/local/bin/startup.sh"]
```

3. Rebuild and restart the container:

```bash
docker-compose down
docker-compose up -d --build
```