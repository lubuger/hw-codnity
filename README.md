# Set up

## Install
- postgres
- php 8.4
- nodejs
- npm
- php-dom

## Configure .env file
- APP_URL=your url
- DB_HOST=your db host
- DB_DATABASE=your db
- DB_USERNAME=your username
- DB_PASSWORD=your password
- VITE_ASSET_HOST=your host
- VITE_ASSET_PORT=your port
- SESSION_DOMAIN=set your domain

### Run commands from project root
- composer install
- php artisan migrate
- php artisan db:seed
- php artisan app:parse-news
- npm i
- npm run build

#### Login
use this credentials:

login: test@example.com
password: password
