# E-WasteHub
## A Web based Information System for Managing an E-Waste Shop

## Introduction

This project, E-WasteHub, develops an online platform for inventory management in the electronics market. Its purpose is to reduce electronic waste (e-waste) and promote sustainability by connecting sellers of refurbished electronics with potential buyers. The platform addresses the problem of toxic environmental hazards caused by e-waste by using advanced inventory systems to track stock levels accurately, reducing excess inventory and waste from unsold electronics.

## Dependencies

For the following system, it requires the following technologies:
- Laravel framework
- PHP 8.2
- composer
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

## License
E-WasteHub is completely free and released under the [MIT license](https://opensource.org/licenses/MIT).
















