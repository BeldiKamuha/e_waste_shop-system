# E-WasteHub
## A Web based Information System for Managing an E-Waste Shop

## Introduction

This project, E-WasteHub, develops an online platform for inventory management in the electronics market. Its purpose is to reduce electronic waste (e-waste) and promote sustainability by connecting sellers of refurbished electronics with potential buyers. The platform addresses the problem of toxic environmental hazards caused by e-waste by using advanced inventory systems to track stock levels accurately, reducing excess inventory and waste from unsold electronics.

## Dependencies

For the following system, it requires the following technologies:
- Laravel framework
- PHP (8.2 or higher)
- Composer
- Apache server or XAMPP
- Preferred IDE
- Jetstream

## Installation
In order to install PHP click [here](https://www.php.net/downloads) and as for [composer](https://getcomposer.org) click on the link.

### Install Laravel

After you have installed PHP and Composer, you may create a new Laravel project via Composer's create-project command:
```

composer create-project laravel/laravel example-app

```
Or, you may create new Laravel projects by globally installing the Laravel installer via Composer:
```
composer global require laravel/installer
 
laravel new example-app
```
Once the project has been created, start Laravel's local development server using Laravel Artisan's serve command:
```
cd example-app
 
php artisan serve
```
Once you have started the Artisan development server, your application will be accessible in your web browser at http://localhost:8000. 

### Install Jetstream

Install Jetstream With Livewire ​

```
php artisan jetstream:install livewire
```

If you would like "teams" support, you can provide the --teams directive to the install command:

```
php artisan jetstream:install livewire --teams
```

Or, Install Jetstream With Inertia ​

```
php artisan jetstream:install inertia
```

If you would like "teams" support with the Inertia stack, provide the --teams directive to the install command:

```
php artisan jetstream:install inertia --teams
```

Dark Mode ​

If you would like to include "dark mode" support when scaffolding your application's frontend, provide the --dark directive when executing the jetstream:install command:

```
php artisan jetstream:install livewire --dark
```

Finalizing the Installation ​

After installing Jetstream, you should install and build your NPM dependencies and migrate your database:

```
npm install
npm run build
php artisan migrate
```
## Usage
1. Clone the repo and cd into it
2. In your terminal `composer install`
3. Rename or copy `.env.example` file to `.env`
4. `php artisan key:generate`
5. Set your database credentials in your .env file 
6. Import db file(database/e_waste_shop.sql) into your database (mysql,sql)
7. `npm install`
8. `npm run watch`
9. Edit .env file :- remove APP_URL
10. `php artisan serve` or use virtual host
11. Visit `localhost:8000` in your browser
12. Visit /admin if you want to access the admin panel. Admin Email/Password: `admin@gmail.com`/`12345678`. User Email/Password: `user@gmail.com`/`12345678`


## Project Structure

```
├── README.md                           
├── app                                  
│   ├── Actions
│   ├── Console
│   ├── Events
│   ├── Exceptions
│   ├── Http
│   ├── Models
│   ├── Providers
│   └── View
├── artisan
├── bootstrap
│   ├── app.php
│   └── cache
├── composer.json
├── composer.lock
├── config
│   ├── app.php
│   ├── auth.php
│   ├── broadcasting.php
│   ├── cache.php
│   ├── cors.php
│   ├── database.php
│   ├── filesystems.php
│   ├── fortify.php
│   ├── hashing.php
│   ├── jetstream.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── sanctum.php
│   ├── services.php
│   ├── session.php
│   └── view.php
├── database
│   ├── factories
│   ├── migrations
│   └── seeders
├── lang
├── node_modules
├── package-lock.json
├── package.json
├── phpunit.xml
├── postcss.config.js
├── public
├── reset_password.sh
├── reset_password.sh.save
├── resources
├── routes
├── storage
├── tailwind.config.js
├── tests
├── vendor
└── vite.config.js
```

## License
E-WasteHub is completely free and released under the [MIT license](https://opensource.org/licenses/MIT).














