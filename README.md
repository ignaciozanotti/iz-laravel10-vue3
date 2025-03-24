# Infrastructure Setup and Testing

## Build the Infrastructure

docker-compose up -d --build

## Test the Infrastructure

### Check Running Containers

docker ps

### Generate Application Key

docker exec -it iz-laravel10-vue3-php php artisan key:generate

### Initialize the Database

For first-time setup, migrate the database and seed it with initial data:

docker exec -it iz-laravel10-vue3-php php artisan migrate:fresh

### Verify Node Container

docker exec -it iz-laravel10-vue3-node node --version

### Verify Database

docker exec -it iz-laravel10-vue3-db psql -U laravel -d laravel

To exit the database prompt:
\q