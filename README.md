## Setup
1. npm install
2. composer install
3. php artisan key:generate
4. maak een .env bestand aan aan de hand van .env.example
5. verander de database informatie in .env naar je eigen informatie.
6. Maak database aan met de naam die in je .env staat
7. php artisan migrate

## Development
1. php artisan serve
2. npm run watch
3. Database aanzetten (XAMPP/WampServer/Laragon)

## Seeder
1. php artisan migrate:fresh
2. composer dump-autoload
3. php artisan db:seed
