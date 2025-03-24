# Infrastructure Setup and Testing

## Build the Infrastructure

docker-compose up -d --build

## Test the Infrastructure

### Check Running Containers

docker ps

### Verify PHP-FPM

curl http://localhost:8000

Verify the output is `Hello from PHP-FPM!%`

### Verify Node Container

docker exec -it iz-laravel10-vue3-node node --version

### Verify Database

docker exec -it iz-laravel10-vue3-db psql -U laravel -d laravel

To exit the database prompt:
\q